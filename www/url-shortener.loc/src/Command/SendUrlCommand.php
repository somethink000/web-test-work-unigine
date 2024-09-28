<?php


namespace App\Command;


use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


#[AsCommand(name: 'set-info')]
class SendUrlCommand extends Command
{
    protected static $defaultName = 'set-info';


    protected function configure(): void
    {
        $this->addArgument('url', InputArgument::REQUIRED, 'Url to send.');
        $this->addArgument('date', InputArgument::REQUIRED, 'Created date to send.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
       
        

        $url = $input->getArgument('url');
        $date = $input->getArgument('date');
        

        //if ( $this->SendUrlData( $url, $date ) ) {

            $output->writeln([
                '',
                "Sended:" ,
                '============',
                "Url: {$url}",
                "Created date: {$date}",
                //"Created date: {}",
                '============',
                '',
            ]);
            
            return Command::SUCCESS;

        // } else {

        //     $output->writeln([
        //         '',
        //         "Writed data is not valid",
        //         '',
        //     ]);

        //     return Command::FAILURE;
        // }


        

       
    }

    // <?php

    // namespace App\Command;
    
    
    // use Symfony\Contracts\HttpClient\HttpClientInterface;
    
    // class SendUrlHttpClient
    // {
    //     public function __construct(
    //         private HttpClientInterface $client
    //     ) {
    //     }
    
    //     public function fetchGitHubInformation(): array
    //     {
    //         $response = $this->client->request(
    //             'GET',
    //             'https://api.github.com/repos/symfony/symfony-docs'
    //         );
    
    //         $statusCode = $response->getStatusCode();
    //         // $statusCode = 200
    //         $contentType = $response->getHeaders()['content-type'][0];
    //         // $contentType = 'application/json'
    //         $content = $response->getContent();
    //         // $content = '{"id":521583, "name":"symfony-docs", ...}'
    //         $content = $response->toArray();
    //         // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
    
    //         return $content;
    //     }
    // }
}