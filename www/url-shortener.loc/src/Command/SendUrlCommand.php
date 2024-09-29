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


#[AsCommand(name: 'set-info')]
class SendUrlCommand extends Command
{
    protected static $defaultName = 'set-info';

    
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
        $request = Request::create('/encode-url?url=someurl', 'GET');
        $response = $kernel->handle($request, HttpKernelInterface::MASTER_REQUEST, false);

       
       // if ( $this->SendUrlData( $url, $date ) ) {

            $output->writeln([
                '',
                "Sended:" ,
                '============',
                "Url: {$url}",
                "Created date: {$date}",
                "Created date: {$response->getContent()}",
                '============',
                '',
            ]);
            
            return Command::SUCCESS;

       // } else {

            // $output->writeln([
            //     '',
            //     "Writed data is not valid",
            //     '',
            // ]);

            // return Command::FAILURE;
        //}
    }

  
}