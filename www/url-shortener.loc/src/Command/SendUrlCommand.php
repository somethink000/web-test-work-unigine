<?php


namespace App\Command;


use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


#[AsCommand(name: 'send_url')]
class SendUrlCommand extends Command
{
    protected static $defaultName = 'send_url';

    
    protected function configure(  ): void
    {
        $this->addArgument('url', InputArgument::REQUIRED, 'Url to send.');
        $this->addArgument('date', InputArgument::REQUIRED, 'Created date to send.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
    

        $url = $input->getArgument('url');
        $date = $input->getArgument('date');
        
        
        // looks like skill issue 
        $kernel = new Kernel('prod', false);
        $request = Request::create('/apply-url', 'POST', [
            'url' => $url,
            'date' => $date,
        ]);
        $response = $kernel->handle($request, HttpKernelInterface::MASTER_REQUEST, false);

       
     
        $output->writeln([
            '',
            "Sended:" ,
            '============',
            "Url: {$url}",
            "Date: {$date}",
            '============',
            '',
            "Resived data: {$response->getContent()}",
            '',
            '',
        ]);
        
        return Command::SUCCESS;

    }

  
}