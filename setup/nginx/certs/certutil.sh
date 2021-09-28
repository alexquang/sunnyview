# sudo apt-get install -y libnss3-tools
mkdir -p $HOME/.pki/nssdb && \
certutil -d sql:$HOME/.pki/nssdb -A -t "P,," -n "localhost" -i localhost.crt