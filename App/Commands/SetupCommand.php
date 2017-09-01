<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SetupCommand extends Command
{

	protected function configure()
	{
		$this->setName('setup')
			->setDescription('Setup application');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$io = new SymfonyStyle($input, $output);

		$io->text('Welcome on urlshortner installer!');
		//1. create a .env file
		//ask database host, user, paswd and database

		$io->section('Database configuration');
		$db_host = $io->ask('What is your mysql host?', '127.0.0.1');
		$db_username = $io->ask('What is your mysql username?', 'root');
		$db_password = $io->ask('What is your mysql password?', '', function ($value) {
			if (empty($value)) {
				return $value;
			}

			return $value;
		});
		$db_database = $io->ask('What is your mysql database name?');

		$output->writeln([
			'Database information:',
			$db_host,
			$db_username,
			$db_password,
			$db_database
		]);
		$io->confirm('It is ok?', true);

		$mysql_enable = $io->ask('You want to import database scheme ?', true);

		//write
		$envConfig = "MYSQL_HOST={$db_host}\nMYSQL_USERNAME={$db_username}\nMYSQL_PASSWORD={$db_password}\nMYSQL_DATABASE={$db_database}\n";

		$io->success('Ok success to set database configuration!');



		$io->section('Api configuration');

		$api_auth = $io->ask("Would you like to generate your api username and password ?", true);

		if ($api_auth == true){
			$api_username = strtoupper(bin2hex(random_bytes(10)));
			$api_password = bin2hex(random_bytes(20));

			$io->note("Your api username is \"{$api_username}\" and your api password is \"{$api_password}\"");
		}else{
			$api_username = $io->ask('What is your api username?', 'USERNAME');
			$api_password = $io->ask('What is your api password?', 'PASSWORD');
		}

		$io->success('Ok success to set api authentification!');
		$envConfig .= "API_AUTH={$api_username}:{$api_password}\n";


		$io->section('Other configuration');
		$base_redirect = $io->ask('What is your base redirect url?', 'http://example.com');
		$app_debug = $io->ask("What is app debug mode ? (1 = debug mode) (0 = production mode)", 0);

		if ($app_debug){

			$io->warning('Warning: App debug is enabled please be careful, all errors will be showed');

		}
		$envConfig .= "APP_DEBUG={$app_debug}\nBASE_REDIRECT_URL={$base_redirect}";

		$File = ".env";
		$Handle = fopen($File, 'w');
		fwrite($Handle, $envConfig);
		fclose($Handle);

		$io->success('Success creating .env file!');

		//import mysql scheme
		if ($mysql_enable){
			//connection à la bdd
			$dbConn = new \Simplon\Mysql\Mysql(
				$db_host,
				$db_username,
				$db_password,
				$db_database
			);

			$dbConn->executeSql("CREATE TABLE `urls` (
							  `id` int(11) NOT NULL,
							  `uuid` varchar(255) NOT NULL,
							  `redirect` varchar(255) NOT NULL,
							  `created_at` datetime NOT NULL,
							  `updated_at` datetime NOT NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8;
							");
			$dbConn->executeSql("ALTER TABLE `urls`
  ADD PRIMARY KEY (`id`);");
			$dbConn->executeSql("ALTER TABLE `urls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;");

			$io->success('Success creating mysql table!');
		}
	}
}