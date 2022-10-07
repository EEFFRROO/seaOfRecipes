<?php


namespace App\Command;


use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:generate:receipts',
    description: 'Generate random receipts.',
    hidden: false,
)]
class GenerateReceiptsCommand extends Command
{
    private Generator $faker;

    public function __construct(string $name = null)
    {
        parent::__construct($name);
        $this->faker = Factory::create('ru_RU');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln($this->faker->email);
        return Command::INVALID;
    }
}