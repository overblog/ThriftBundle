<?php
namespace Overblog\ThriftBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;
use Thrift\Protocol\TBinaryProtocolAccelerated;

use Thrift\Transport\TSocket;

use OverblogComment\InternalApiBundle\ThriftModel\Comment\Client\CommentClient;
use OverblogComment\InternalApiBundle\ThriftModel\Comment\Definition\CommentUser;
use OverblogComment\InternalApiBundle\ThriftModel\Comment\Definition\Comment;

class ClientCommand extends ContainerAwareCommand
{
    protected function configure()
	{
        $this->setName('thrift:client')
		  ->setDescription('Thrift Client');
	}

    protected function execute(InputInterface $input, OutputInterface $output)
	{
        $time_start = microtime(true);

        try
        {
            $client = $this->getContainer()->get('thrift')->getClient('comment_socket');

            $user = new CommentUser();
            $user->token = 121354984651354647;
            $user->origin = 'Overblog';
            $user->name = 'Name 1';
            $user->email = 'foo@bar.com';
            $user->ip = ip2long('127.0.0.7');

            $comment = new Comment();
            $comment->id_element = 1;
            $comment->id_element_parent = 1;
            $comment->comment = 'Test de commentaire';
            $comment->user = $user;

            $commentId = $client->createComment($comment);

            var_dump($commentId, (microtime(true) - $time_start));

            $commentId = 1;

            $like = $client->like($commentId);
            var_dump($like, (microtime(true) - $time_start));

            $dislike = $client->dislike($commentId);
            var_dump($dislike, (microtime(true) - $time_start));

//            $initializePopularity = $client->initializePopularity(1);
//            var_dump($initializePopularity, (microtime(true) - $time_start));
        }
        catch(Overblog\InternalApiBundle\Thrift\packages\Comment\InvalidValueException $e)
        {
            $output->writeln($e->error_msg);
        }
    }
}