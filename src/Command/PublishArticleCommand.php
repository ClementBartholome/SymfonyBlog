<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\ArticleRepository;

#[AsCommand(
    name: 'app:publish-article',
    description: 'Publish articles marked as "to be published"',
)]
class PublishArticleCommand extends Command
{   
    private $articleRepository;
    private $manager;

    public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $manager, string $name = null)
    {
        $this->articleRepository = $articleRepository;
        $this->manager = $manager;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $articles = $this->articleRepository->findBy([
            'state' => 'to be published'
        ]);

        foreach($articles as $article) {
            $article->setState('published');
        }

        $this->manager->flush();

        $io->success(count($articles). ' articles publiés');

        return Command::SUCCESS;
    }
}
