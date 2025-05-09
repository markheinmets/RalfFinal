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


// Hooks
task('build', function () {
    cd('{{release_path}}');
    run('npm install');
});

after('deploy:update_code', 'build');

after('deploy:failed', 'deploy:unlock');