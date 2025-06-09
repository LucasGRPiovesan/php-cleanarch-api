<?php

use PHPUnit\Framework\TestCase;
use Application\UseCases\StoreUserUseCase;
use Domain\Repositories\{ProfileRepositoryInterface, UserRepositoryInterface};
use Domain\Entities\{Profile, User};
use Application\DTO\{StoreUserDTO, FetchUserDTO};
use Ramsey\Uuid\Uuid;

class StoreUserUseCaseTest extends TestCase
{
  public function testShouldCreateUserSuccessfully()
  {
    $input = StoreUserDTO::fromArray([
      'uuid_profile' => 'profile-123',
      'name' => 'John Doe',
      'email' => 'john@example.com',
      'password' => 'secret'
    ]);

    /** @var \PHPUnit\Framework\MockObject\MockObject&\Domain\Entities\Profile */
    $profileMock = $this->createMock(Profile::class);
    
    /** @var \PHPUnit\Framework\MockObject\MockObject|\Domain\Repositories\ProfileRepositoryInterface */
    $profileRepositoryMock = $this->createMock(ProfileRepositoryInterface::class);
    $profileRepositoryMock
      ->expects($this->once())
      ->method('fetch')
      ->with($input->uuid_profile)
      ->willReturn($profileMock);

    // Cria manualmente o objeto que será retornado pelo store
    $userEntity = new User(
      Uuid::uuid4()->toString(),
      $input->name,
      $input->email,
      $input->password,
      $profileMock
    );

    /** @var \PHPUnit\Framework\MockObject\MockObject|\Domain\Repositories\UserRepositoryInterface */
    $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
    $userRepositoryMock
      ->expects($this->once())
      ->method('store')
      ->with($this->isInstanceOf(User::class))
      ->willReturn($userEntity);

    // Use case
    $useCase = new StoreUserUseCase($userRepositoryMock, $profileRepositoryMock);
    $user = $useCase->execute($input);

    $this->assertInstanceOf(FetchUserDTO::class, $user);
    $this->assertEquals('John Doe', $user->name);
    $this->assertEquals('john@example.com', $user->email);
  }

  public function testShouldThrowExceptionWhenCreateUser()
  {
    $input = StoreUserDTO::fromArray([
      'uuid_profile' => 'profile-123',
      'name' => 'John Doe',
      'email' => 'john@example.com',
      'password' => 'secret'
    ]);

    $profileMock = $this->createMock(Profile::class);

    /** @var \PHPUnit\Framework\MockObject\MockObject&\Domain\Repositories\ProfileRepositoryInterface */
    $profileRepositoryMock = $this->createMock(ProfileRepositoryInterface::class);
    $profileRepositoryMock
      ->expects($this->once())
      ->method('fetch')
      ->with($input->uuid_profile)
      ->willReturn($profileMock);

    /** @var \PHPUnit\Framework\MockObject\MockObject&\Domain\Repositories\UserRepositoryInterface */
    $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
    $userRepositoryMock
      ->expects($this->once())
      ->method('store')
      ->willThrowException(new \RuntimeException('Error creating user'));

    $useCase = new StoreUserUseCase($userRepositoryMock, $profileRepositoryMock);

    $this->expectException(\RuntimeException::class);
    $this->expectExceptionMessage('Error creating user');

    $useCase->execute($input);
  }


  public function testShouldThrowExceptionWhenProfileNotFound()
  {
    $input = StoreUserDTO::fromArray([
      'uuid_profile' => 'invalid-uuid',
      'name' => 'Jane Doe',
      'email' => 'jane@example.com',
      'password' => 'secret'
    ]);

    /** @var \PHPUnit\Framework\MockObject\MockObject|\Domain\Repositories\ProfileRepositoryInterface */
    $profileRepositoryMock = $this->createMock(ProfileRepositoryInterface::class);
    $profileRepositoryMock
      ->method('fetch')
      ->willReturn(null);

    /** @var \PHPUnit\Framework\MockObject\MockObject|\Domain\Repositories\UserRepositoryInterface */
    $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

    $useCase = new StoreUserUseCase($userRepositoryMock, $profileRepositoryMock);

    $this->expectException(\RuntimeException::class);
    $this->expectExceptionMessage('Profile not found');

    $useCase->execute($input);
  }
}
