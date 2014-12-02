# Easy-Thumb

Ce dépot vous permet d'utiliser notre service de création de miniatures.

## JQuery

Le plugin jquery vous permet d'ajouter une miniature de l'url au survol des lients de votre site.

```html
<a href="http://www.google.fr">Google</a>

<script>
	$('a').easythumb({
		size: '640x480' // Thumb size
	});
</script>

```

## Php (premium)

La classe PHP vous permet de générer les url pour l'affichages des miniatures premium.

``` PHP
// Set API Key
EasyThumb::api('APIKEY', 'SECRETKEY');

// Set thumb type
EasyThumb::type(EasyThumb::TYPE_FULL);

// Set wait url
EasyThumb::wait('http://www.wait.com/logo.png');

// Display img url for 640x480
echo EasyThumb::img('http://www.google.fr', EasyThumb::SIZE_640x480);

```
