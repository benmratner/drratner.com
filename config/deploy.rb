# config valid only for current version of Capistrano
set :application, 'SITE_PACKAGE'
set :repo_url, 'SITE_REPO'
set :scm, :git

set :linked_dirs, ["wp-content/uploads"]

set :studio_run_npm, true

# install composer dependencies
task :composer do
  run_locally do
    execute "composer install"
  end
end

# Zip necessary files not included in repo
#task :zip_files do
  #run_locally do
		#execute "tar -zcvf SITE_PACKAGE_files.tar.gz wp/ -C wp-content/ plugins/"
	#end
#end

# Upload and unpackage zip
#task :upload_zip do
    #on roles :all do
        #upload! "SITE_PACKAGE_files.tar.gz", "#{current_path}"
        #execute "cd #{current_path} && tar -zxvf SITE_PACKAGE_files.tar.gz && rm -f SITE_PACKAGE_files.tar.gz && mv plugins/ #{current_path}/wp-content"
    #end
#end

#task :cleanup do
  #run_locally do
		#execute "rm -rf SITE_PACKAGE_files.tar.gz"
	#end
#end

task :restart_services do
  on roles :all do
    execute "sudo service apache2 restart"
  end
end

#before :zip_files, :composer
#after :deploy, :zip_files
#after :zip_files, :upload_zip
#after :upload_zip, :cleanup
#
#after "deploy", "deploy:cleanup"
