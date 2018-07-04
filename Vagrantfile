# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  # base box
  config.vm.box = "ubuntu/trusty64"
  config.vm.box_version = "20171113.0.0"

  # provisioning script
  config.vm.provision :shell, :path => "bin/vagrant/bootstrap.sh"

  # Sync vagrant folder in VM
  config.vm.synced_folder ".", "/vagrant"

  config.vm.provider "virtualbox" do |v|
    v.memory = 2048
  end

	# restart services on up
	config.trigger.after [:up], :stdout => true do
		system('vagrant ssh -c "sudo service apache2 restart && sudo service mysql restart"')
	end

  # ssh forwarding
  config.ssh.forward_agent = true

  # port forwarding
  config.vm.network :forwarded_port, guest: 80, host: 8080
  config.vm.network :forwarded_port, guest: 443, host: 8443

end
