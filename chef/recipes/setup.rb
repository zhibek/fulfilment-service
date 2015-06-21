include_recipe "site::npm_extensions"
include_recipe "site::php_extensions"

package "git"

directory "#{node.site.root_path}" do
  owner node.user.name
  mode "0755"
  recursive true
end

%w(logs).each do |dir|
  directory "#{node.site.root_path}/#{dir}" do
    owner node.user.name
    mode "0755"
    recursive true
  end
end

directory "/etc/nginx/ssl" do
  owner "root"
  group "root"
  mode "0644"
  action :create
end

cookbook_file "#{node.site.environment}.crt" do
  path "/etc/nginx/ssl/server.crt"
  mode "0644"
end

cookbook_file "#{node.site.environment}.key" do
  path "/etc/nginx/ssl/server.key"
  mode "0644"
end

template "#{node.nginx.dir}/sites-available/#{node.site.name}.conf" do
  source "nginx.conf.erb"
  mode "0644"
end

nginx_site "default" do
  enable false
end

nginx_site "#{node.site.name}.conf"

service "nginx" do
  action [:enable, :restart]
end

service "redis-server" do
  action [:enable, :start]
end

execute "deploy" do
  command "#{node.site.root_path}/deploy.sh"
  cwd "#{node.site.root_path}"
  only_if do ::File.exists?("#{node.site.root_path}/deploy.sh") end
end

execute "create database #{node.site.database_name}" do
    command "mysql -u#{node.site.database_username} -p#{node.site.database_password} -e 'CREATE DATABASE IF NOT EXISTS `#{node.site.database_name}`'"
    user "vagrant"
end