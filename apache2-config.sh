#!/bin/bash
# Make sure this file is executable by running chmod +x apache2-config.sh before building your image

cat >> /var/www/html/wp-config.php <<-EOF
/* SMTP Settings */
add_action( 'phpmailer_init', 'mail_smtp' );
function mail_smtp( \$phpmailer ) {
  \$phpmailer->isSMTP();
  \$phpmailer->Host = getenv('WORDPRESS_SMTP_HOST');
  \$phpmailer->SMTPAutoTLS = true;
  \$phpmailer->SMTPAuth = true;
  \$phpmailer->Port = getenv('WORDPRESS_SMTP_PORT');
  \$phpmailer->Username = getenv('WORDPRESS_SMTP_USERNAME');
  \$phpmailer->Password = getenv('WORDPRESS_SMTP_PASSWORD');
  // Additional settings
  \$phpmailer->SMTPSecure = "tls";
  \$phpmailer->From = getenv('WORDPRESS_SMTP_FROM');
  \$phpmailer->FromName = getenv('WORDPRESS_SMTP_FROM_NAME');
}
EOF

# Run apache2
exec "apache2-foreground"