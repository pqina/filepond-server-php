Vagrant.configure("2") do |config|

    config.vm.box = "scotch/box"
    config.vm.network "private_network", ip: "192.168.33.11"
    config.vm.hostname = "scotchbox"
    config.vm.synced_folder ".", "/var/www", :mount_options => ["dmode=777", "fmode=666"]

    config.vm.provision "shell", inline: <<-SHELL
        mv /var/www /var/www/public_html
        sudo sed -i s,/var/www/public,/var/www,g /etc/apache2/sites-available/000-default.conf
        sudo sed -i s,/var/www/public,/var/www,g /etc/apache2/sites-available/scotchbox.local.conf
        sudo service apache2 restart
    SHELL

end