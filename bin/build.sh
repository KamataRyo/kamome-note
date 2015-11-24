#!/usr/bin/env bash

set -e

$ curl -L https://raw.githubusercontent.com/cognitom/dotfiles/master/lib/sketchtool.sh | sudo sh
npm install
npm run build
