<?php

use Application\DTO\{FetchProfileDTO, StoreProfileDTO};
use Application\UseCases\StoreProfileUseCase;
use Domain\Entities\Profile;
use Domain\Repositories\ProfileRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class StoreProfileUseCaseTest extends TestCase
{
  public function testShouldCreateProfileSuccessfully()
  {
    $input = StoreProfileDTO::fromArray([
      'profile' => 'Admin',
      'description' => 'Admin profile'
    ]);

    $profileEntity = new Profile(
      Uuid::uuid4()->toString(),
      $input->profile,
      $input->description
    );

    /** @var \PHPUnit\Framework\MockObject\MockObject&\Domain\Repositories\ProfileRepositoryInterface */
    $profileRepositoryMock = $this->createMock(ProfileRepositoryInterface::class);
    $profileRepositoryMock
      ->expects($this->once())
      ->method('store')
      ->with($this->isInstanceOf(Profile::class))
      ->willReturn($profileEntity);

    $useCase = new StoreProfileUseCase($profileRepositoryMock);

    $result = $useCase->execute($input);

    $this->assertInstanceOf(FetchProfileDTO::class, $result);
    $this->assertEquals('Admin', $result->profile);
    $this->assertEquals('Admin profile', $result->description);
  }

  public function testShouldThrowExceptionWhenCreateProfile()
  {
    $input = StoreProfileDTO::fromArray([
      'profile' => 'Admin',
      'description' => 'Admin profile'
    ]);

    /** @var \PHPUnit\Framework\MockObject\MockObject&\Domain\Repositories\ProfileRepositoryInterface */
    $profileRepositoryMock = $this->createMock(ProfileRepositoryInterface::class);
    $profileRepositoryMock
      ->expects($this->once())
      ->method('store')
      ->willThrowException(new RuntimeException('Error creating profile'));

    $useCase = new StoreProfileUseCase($profileRepositoryMock);

    $this->expectException(RuntimeException::class);
    $this->expectExceptionMessage('Error creating profile');

    $useCase->execute($input);
  }
}
