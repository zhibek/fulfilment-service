VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "ubuntu/trusty64"
  config.vm.synced_folder "./", "/var/www", id: "web-root"
  config.vm.network "forwarded_port", guest: 22, host: 2222, id: "ssh", auto: true
  config.vm.network "private_network", type: "dhcp"

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--name", "fulfilment-system"]
    vb.customize ["modifyvm", :id, "--memory", "1024"]
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
    #vb.gui = true
  end

  config.berkshelf.enabled = true
  config.berkshelf.berksfile_path = "chef/Berksfile"

  config.vm.provision :chef_solo do |chef|
    chef.log_level = "debug"
    chef.verbose_logging = true
    chef.run_list = [
      "recipe[site::default]"
    ]
  end

end