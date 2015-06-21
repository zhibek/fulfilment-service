include_recipe "nodejs::npm"

nodejs_npm "bower" do
  action :install
end

nodejs_npm "grunt" do
  action :install
end