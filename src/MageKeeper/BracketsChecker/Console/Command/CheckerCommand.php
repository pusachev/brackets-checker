<?php

namespace MageKeeper\BracketsChecker\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use MageKeeper\BracketsChecker\Validator\BracketsValidatorInterface;

class CheckerCommand extends Command
{
    const COMMAND_NAME = 'magekeeper:brackects-checker:check';
    const ARG_NAME     = 'expression';

    /** @var BracketsValidatorInterface */
    protected $validator;

    /**
     * CheckerCommand constructor.
     * @param BracketsValidatorInterface $bracketsValidator
     * @param null|string                $name
     */
    public function __construct(BracketsValidatorInterface $bracketsValidator, $name = null)
    {
        $this->validator = $bracketsValidator;

        parent::__construct($name);
    }

    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
             ->setDescription('Check that all brackets in expression a correct')
             ->setHelp('This command allows you to check expression on correct placement of the brackets')
             ->addArgument(self::ARG_NAME, InputArgument::REQUIRED, 'Expression string to check');
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $expression = $input->getArgument(self::ARG_NAME);

        if ($this->validator->validate($expression)) {
            $output->writeln(sprintf('Expression "%s" is <info>correct</info>', $expression));
        } else {
            $output->writeln(sprintf('Expression "%s" is <error>incorrect</error>', $expression));
        }
    }
}
