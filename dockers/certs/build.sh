#!/bin/bash

domain='_.app.local'
rm $domain  -Rf
./minica --domains '*.app.local'
cat ./$domain/cert.pem ./$domain/key.pem > ./$domain/all.pem
cat ./$domain/cert.pem ./$domain/key.pem > ./$domain/$domain
chmod 755 ./$domain



domain='foo.local'
rm $domain  -Rf
./minica --domains $domain
cat ./$domain/cert.pem ./$domain/key.pem > ./$domain/all.pem
cat ./$domain/cert.pem ./$domain/key.pem > ./$domain/$domain
chmod 755 ./$domain 



