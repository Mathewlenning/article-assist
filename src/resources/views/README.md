# Article Assist View Organization #

This document outlines the conventions used in the `resources/views` folder.

## Template headers ##
All templates should have a template header that lists all the variables used by that template

Each template should also have a list of required variables at the top so
that it can be referenced when trying to use the template. This will ensure that
anyone using the template in a different context that the original, can easily determine
what data needs to be provided without reading the entire template.

**Example: templates/index.blade.php**
```PHP 
<?php
/**
 * @var Illuminate\Database\Eloquent\Model|null $model
 * @var Illuminate\Http\Request $request
 * @var App\Http\Controllers\ $config
 * @var App\Services\SystemNotifications\MessageQueue $msgQue
 * @var ?string $page_title
 * @var ?string $body_class
 * @var ?string $additionalMetaTemplate
 * @var ?string $headerTemplate
 * @var string $bodyTemplate
 * @var ?string $footerTemplate
 * @var ?string $additionalScriptsTemplate
 */
?>
...
```

## Folder structure and naming conventions ##
There are different types of templates stored in the `resources/views` folder.
In order to keep a consistent structure each type should follow 
the structure and naming conventions detailed herein.

### Asset Templates ###
Asset templates are used for including web assets like JS, CSS and Images. 
This template type also depends on assets located in 
the `/public/assets` folder.

Templates in this directory should be stored in a directory 
named after the file name of the asset.

So if you have a file called `icons.svg` in the `/public/assets` folder, 
then the template should be stored in 
`/resources/views/assets/icons`.

Additionally, asset templates should use the asset file extension 
as their name. So the template for `icon.svg` should be named `svg.blade.php`

***Examples***
```
Asset                       Template
______________________________________________________________________
/public/assets/icon.svg   | /resources/assets/icons/svg.blade.php
__________________________|___________________________________________
/public/assets/app.css    | /resources/assets/app/css.blade.php
__________________________|___________________________________________
/public/assets/app.js     | /resources/assets/app/js.blade.php
__________________________|___________________________________________
```

The goal here is to align the `/public/assets` content with 
the blade `@include` syntax. In this example we can include the 
asset by using `@include('assets.icons.svg')` and know 
that we are including `/public/assets/icons.svg`

### Resource Views ###
Resource view templates are the meat and potatoes of our application. 
These templates are used to render all pages associated with 
a specific resource.

#### Data Resources ####
Data resources are those that deal with database records. 
Data Resources folders should be named after the lowercase plural form of their name.

***Examples***

```
Resource              -  Folder     
___________________________________________________
App\Models\Document   | /resources/views/documents
______________________|____________________________
App\Models\User       | /resources/views/users
______________________|____________________________
```
##### Top Level Templates #####
Top level templates are templates that utilize a 
layout template from `/resources/layouts`. They should define 
all variables needed by the layout template.

***Example: /resource/views/documents/form.blade.php***
```php
<?php
$page_title = 'Article Assistant - Edit Document';
$body_class = 'bg-dark';
$bodyTemplate = 'documents.form.body';
$additionalScriptsTemplate = 'assets.sortable.js';
?>

@include('system.templates.index');
```
Each data resource view folder should have a top level 
template named `default.blade.php`. The default template is used 
when calling the resource without the view variable parameter.

Except for the default, top level templates should use a descriptive noun 
as their name. e.g. `form.blade.php`, `signup.blade.php`

Sub-templates should be stored in a folder named after the top level 
template they are associated with. 

***Example*** 
```
Top level             Sub template 
___________________________________________________
default.blade.php   | /resources/documents/default/table.blade.php
____________________|______________________________
form.blade.php      | /resources/documents/form/body.blade.php
____________________|______________________________
```

Sub-templates that have sub-templates of their own should use the same naming convention.
So sub-template of `/resources/documents/default/table.blade.php` 
should be stored in `/resources/documents/default/table`

### System ###
This folder holds generic templates used throughout the system.
Although there are no defined conventions, folders structure 
should be similar to the conventions used for resource templates. 

### Layouts ###
Layouts are top level templates used for page layouts.
Layouts should not use sub-templates directly. Instead, they should define
include variables for dynamic content that can be set by resource views.

The variables they define should use descriptive names suffixed with 
the word `Template` to indicate that they belong to a layout. 

***Example: /resources/layout/index.blade.php***

```php
<?php
/**
 * @var Illuminate\Database\Eloquent\Model|null $model
 * @var Illuminate\Http\Request $request
 * @var App\Services\Mvsc\Controllers\ $config
 * @var \App\Services\Mvsc\SystemNotifications\MessageQueue $msgQue
 * @var ?string $page_title
 * @var ?string $body_class
 * @var ?string $additionalMetaTemplate
 * @var ?string $headerTemplate
 * @var string $bodyTemplate
 * @var ?string $footerTemplate
 * @var ?string $additionalScriptsTemplate
 */
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('system.meta')
    @if(!empty($additionalMetaTemplate))
        @include($additionalMetaTemplate)
    @endif
    <title>{{$page_title}}</title>
    @include('assets.bootstrap.css')
    @include('assets.app.css')
    @include('assets.app.js')
</head>
<body class="antialiased {{$body_class}}">
@include('assets.icons.svg')
@if(!empty($headerTemplate))
    @include($headerTemplate)
@endif
@if($msgQue->has())
    @include('system.notifications')
@endif
@include($bodyTemplate)
@if(!empty($footerTemplate))
    @include($footerTemplate)
@endif

@include('assets.js.bootstrap.js')
@if(!empty($additionalScriptsTemplate))
    @include($additionalScriptsTemplate)
@endif
</body>
</html>
```
In the above example template `$headerTemplate`, `$bodyTemplate`, `$footerTemplate`, and `$additionalScriptsTemplate`
are intended to be set by resource views that use this template.
