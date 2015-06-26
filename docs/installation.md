# Installation and Configuration

## Download

Download using composer by running the following command:

```
$ composer require --prefer-dist bedezign/yii2-audit "*"
```

Or add a `require` line to your `composer.json`: 

```
{
    "require": {
        'bedezign/yii2-audit: "*"
    }
}
```

## Migrations

Run the migrations from the `migrations` folder to create the relevant tables:  

```
$ php yii migrate --migrationPath=@bedezign/yii2/audit/migrations`
```

## Configuration

Add a module to your configuration (with optional extra settings) and if it needs to auto trigger, also add it to the bootstrap:

Example:

```php
'bootstrap' => ['log', 'audit', ...],
'controllerNamespace' => 'frontend\controllers',

'modules' => [
    'audit' => [
        'class' => 'bedezign\yii2\audit\Audit',
        'ignoreActions' => ['debug/*', 'audit/*'],
    ],
],
```

This installs the module with auto loading, instructing it to not log anything debug related.

Word of caution: The module is configured by default to only allow viewing access to users with the role 'admin'. This functionality is only available in Yii if you have enabled [RBAC](http://www.yiiframework.com/doc-2.0/guide-security-authorization.html#role-based-access-control-rbac) (via the `authManager`-component). If not, please set this option to `null`. If you do so you should consider activating the `accessUsers`-option, you don't want to give everyone access to your audit data!


### Additional options

```php
'modules' => [
    'audit' => [
        'class' => 'bedezign\yii2\audit\Audit',
        'db' => 'db', // Name of the component to use for database access
        'trackActions' => ['*'], // List of actions to track. '*' is allowed as the last character to use as wildcard
        'ignoreActions' => ['audit/*', 'debug/*'], // Actions to ignore. '*' is allowed as the last character to use as wildcard (eg 'debug/*')
        'maxAge' => 'debug', // Maximum age (in days) of the audit entries before they are truncated
        'accessIps' => ['127.0.0.1', '192.168.*'], // IP address or list of IP addresses with access to the viewer, null for everyone (if the IP matches)
        'accessRoles' => ['admin'], // Role or list of roles with access to the viewer, null for everyone (if the user matches)
        'accessUsers' => [1, 2], // User ID or list of user IDs with access to the viewer, null for everyone (if the role matches)
    ],
],
```

### Selective Logging

If you only want to log the database changes, javascript and errors you should use the following module setting. Standard pageview logging will be ignored.

```php
'modules' => [
    'audit' => [
        'class' => 'bedezign\yii2\audit\Audit',
        'ignoreActions' => ['*'],
    ],
],
```

## Viewing the audit data

Assuming you named the module "audit" you can then access the audit module through the following URL:

```
http://localhost/path/to/index.php?r=audit
```