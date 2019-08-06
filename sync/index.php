<?php

/*
setup git over https

- add this script to your repository (as an example as `sync/index.php`)
- `git clone` the repository on the server
- setup a webhook targetting this php script
  - url: path to this script (`http://libregraphicsmeeting.org/2018/sync/`)
  - type json (does not really care)
  - secret: ... does not seem to be in the json payload
- each time your repository will be pushed, it will be deployed (pulled...) to the server


setup git over ssh (does not work for tuxfamily.org):

- setup webhook
- url: http://libregraphicsmeeting.org/2018/sync/
- type: json
- secret: asecret
- just the push event
- use ssh-keygen to create a pair of ssh keys in the same director where your script is located
- upload the public key as a deploy key for the repository
- `ssh -i `id_rsa` git@github.com` should give the friendly message
  `Hi {user}! You've successfully authenticated, but GitHub does not provide shell access.`
- fail: tuxfamily seems to be blocking outbound requests.


resources:

- https://developer.github.com/v3/guides/managing-deploy-keys/
- https://gist.github.com/zhujunsan/a0becf82ade50ed06115
- https://www.justinsilver.com/technology/github-multiple-repository-ssh-deploy-keys/
- https://gist.github.com/jexchan/2351996
- https://stackoverflow.com/questions/4565700/specify-private-ssh-key-to-use-when-executing-shell-command-with-or-without-ruby
*/

// debug information to test if the script is working
// file_put_contents("log.txt", json_encode($_REQUEST));
// $data = json_decode(file_get_contents('php://input'), true);
// print_r($data);
// file_put_contents("json.txt", json_encode($data));

shell_exec( 'cd .. && git reset --hard HEAD && git pull' );
