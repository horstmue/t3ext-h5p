# TYPO3 H5P extension

H5P makes it easy to create, share and reuse HTML5 content and applications. H5P empowers everyone to create rich and interactive web experiences more efficiently - all you need is a web browser and a website with an H5P plugin.

https://h5p.org/
Checkout all the available content types: https://h5p.org/content-types-and-applications

This is forked from https://github.com/eckonator/t3ext-h5p. Thanks to Markus Eckert (https://github.com/eckonator) for this great work.And all the former contributors especially to Michiel Roos https://github.com/Tuurlijk for the former Typo3-Extension (https://github.com/Tuurlijk/t3ext-h5p) 


### Important note
To avoid double versions of the H5P libraries, symbolic links have to be created during the installation process. This ensures that the H5P libraries are only installed once, saving disk space and improving performance.
Add the following lines to the composer.json file in your root composer.json:
```json
"scripts": {
    "post-install-cmd": [
        "@link-h5p-assets"
    ],
    "post-update-cmd": [
        "@link-h5p-assets"
    ],
    "link-h5p-assets": [
        "mkdir -p packages-shared/t3ext-h5p/Resources/Public/Lib",
        "ln -sfn ../../../../../vendor/h5p/h5p-core packages-shared/t3ext-h5p/Resources/Public/Lib/h5p-core",
        "ln -sfn ../../../../../vendor/h5p/h5p-editor packages-shared/t3ext-h5p/Resources/Public/Lib/h5p-editor"
    ]
}
```
