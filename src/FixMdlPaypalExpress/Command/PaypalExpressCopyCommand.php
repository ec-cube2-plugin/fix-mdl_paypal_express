<?php

/*
 * This file is part of EC-CUBE2 CLI.
 *
 * (C) Tsuyoshi Tsurushima.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FixMdlPaypalExpress\Command;

use Eccube2\Init;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PaypalExpressCopyCommand extends Command
{
    protected static $defaultName = 'paypal-express:copy';

    protected function configure()
    {
        $this
            ->setDescription('ペイパルテンプレートのコピーを行います')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        Init::init();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('ペイパルテンプレート ファイルコピー');

        $directories = array(
            'dropped_item_noticer' => array(
                'from' => PLUGIN_UPLOAD_REALDIR . DROPPED_ITEMS_NOTICER_PLUGIN_NAME . '/templates/',
                'to' => TEMPLATE_REALDIR . 'dropped_item_noticer/',
            ),
        );
        $files = array(
            'sphone' => array(
                array(
                    'from' => MODULE_REALDIR . MDL_PAYPAL_EXPRESS_CODE . '/confirm_sphone_html5.tpl',
                    'to' => SMARTPHONE_TEMPLATE_REALDIR . 'mdl_paypal_express/',
                ),
                array(
                    'from' => MODULE_REALDIR . MDL_PAYPAL_EXPRESS_CODE . '/error_sphone.tpl',
                    'to' => SMARTPHONE_TEMPLATE_REALDIR . 'mdl_paypal_express/',
                ),
            ),
            'default' => array(
                array(
                    'from' => MODULE_REALDIR . MDL_PAYPAL_EXPRESS_CODE . '/confirm.tpl',
                    'to' => TEMPLATE_REALDIR . 'mdl_paypal_express/',
                ),
                array(
                    'from' => MODULE_REALDIR . MDL_PAYPAL_EXPRESS_CODE . '/error.tpl',
                    'to' => TEMPLATE_REALDIR . 'mdl_paypal_express/',
                ),
            ),
        );

        foreach ($directories as $name => $directory) {
            $io->section($name);

            if (is_dir($directory['to'])) {
                if (!$io->confirm($directory['to'] . ' が存在します。強制的にコピーしますか？', false)) {
                    $io->text($directory['to'] . ' へのコピーをスキップしました');
                    continue;
                }
            }

            \SC_Utils_Ex::copyDirectory($directory['from'], $directory['to']);
            $io->text($directory['from'] . ' から ' . $directory['to'] . ' にコピーしました');
        }

        foreach ($files as $name => $_files) {
            $io->section($name);

            foreach ($_files as $file) {
                if (!is_dir($file['to'])) {
                    mkdir($file['to']);
                }

                copy($file['from'], $file['to']);
                $io->text($file['from'] . ' を ' . $file['to'] . ' にコピーしました');
            }
        }
    }
}
