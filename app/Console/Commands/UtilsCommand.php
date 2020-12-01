<?php

namespace App\Console\Commands;

use App\Mail\ScrapeFailed;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class UtilsCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'utils:general {action} {--flag1=} {--flag2=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'General utility commands,{syncTaskDateToUpdatedCalender}';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		 
	}
}
