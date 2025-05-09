<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:markheinmets/RalfFinal.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('ta23heinmets.itmajakas.ee')
    ->set('remote_user', 'virt123054')
    ->set('http_user', 'virt123054')
    ->set('identity_file', '~/.ssh/id_rsa_zone')
    ->set('deploy_path', '~/domeenid/www.ta23heinmets.itmajakas.ee/hajus-ta-23');

// Tasks

desc('Build frontend assets');
task('build:assets', function () {
    within('{{release_path}}', function () {
        run('npm ci');
        run('npm run build');
    });
});

// Hooks

after('deploy:vendors', 'build:assets');
after('deploy:failed', 'deploy:unlock');
