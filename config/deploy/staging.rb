set :branch, ENV['branch']  || 'develop'
set :deploy_env, 'staging'
set :deploy_to, '/home/ubuntu/deploy/SITE_PACKAGE'
set :plugins_loc, '/home/ubuntu/deploy/SITE_PACKAGE/wp-content/'
set :keep_releases, 1

server 'ssh.studiolabs.com',
  user: 'ubuntu',
  roles: '%W{web app}',
  ssh_options: {
    user: 'ubuntu',
    port: 38564,
    auth_methods: %w{publickey}
  }

# symlink the settings file
task :symlink_config do
	on roles :all do
		execute "ln -fs wp-config.php.staging #{current_path}/wp-config.php"
	end
end

after :deploy, :symlink_config
after :symlink_config, :restart_services
