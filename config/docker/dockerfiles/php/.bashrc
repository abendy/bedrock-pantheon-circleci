# Add global Composer to $PATH
export COMPOSER_ALLOW_SUPERUSER=1
export PATH="vendor/bin:$PATH"
export PATH="$(composer config -g home)/vendor/bin:$PATH"

# Fix for Wp-Cli pager
# https://github.com/wp-cli/wp-cli/issues/3840#issuecomment-282131848
export PAGER="busybox more"
export TERM="xterm"

# Disable the `allow-root` warning and run Wp-Cli as root for all commands
wp() {
  /usr/local/bin/wp "$@" --allow-root
}
