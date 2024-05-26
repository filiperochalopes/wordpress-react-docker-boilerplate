# Exemplo de uso de aplicação React com WordPress

### Estrutura de requisição WORDPRESS REST API

`http://192.168.100.22:9082/wp/wp-json/wp/v2/posts`

```.htaccess
# BEGIN WordPress
# The directives (lines) between "BEGIN WordPress" and "END WordPress" are
# dynamically generated, and should only be modified via WordPress filters.
# Any changes to the directives between these markers will be overwritten.

<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /wp/
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /wp/index.php [L]
</IfModule>

# END WordPress
```
