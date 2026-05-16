sudo apt install elasticsearch -y
sudo apt install kibana -y
sudo apt install logstash -y
sudo apt install filebeat -y

# Enable system module
sudo filebeat modules enable system

# Start Filebeat
sudo systemctl start filebeat

# Enable on system boot
sudo systemctl enable filebeat
