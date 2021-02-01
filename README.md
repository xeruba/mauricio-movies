# mauricio-movies
## Requirements
* Magento: 2.3.4

## How to install
* command - composer require mauricio/module-movies
* link    - https://packagist.org/packages/mauricio/module-movies
* version - version 1.0.1


## After installing
* Is important to change the module's configuration data, which are: 
    * 'api_key' (authentication key in api movies), 
    * 'price' and 'stock' (these are the default values when creating a new product, <br />but it can be changed on the screen whenever you create a new product).

## About the module
1. Integration with the Movies API (admin): 
    1. The integration with the API is performed on the backend,through the same endpoint<br />used to access the movies index page. But, the pagination was done using JavaScript;
1. Importing products (admin): 
    1. An 'attribute_set' was created, which has the 'is_movie' attribute,<br />used to represent products that are movies;
1. InstallSchema and InstallData (admin): 
    1. In addition to InstallSchema for the creation of new product attributes,<br />a new table has also been created in the database, which serves to maintain<br />the data regarding the movies that have been saved as favorites by customers;
1. 'Add to favorites' button: 
    1. Was appended to the product view through the file “product.info.addto”;
1. Screen to view the top 10 favorite movies (admin): 
    1. ui_components was used to create the table with the data.

## Screenshots
#### Custom admin navigation bar  <br /> 
![Custom admin navigation bar](https://lh4.googleusercontent.com/kQ3ZYIMOvH3bG5AOMKhgKlZQuHSt8trBRVo71HHKU1i4TOqBSPhCh1kuAc9QqXhGxJF4caHWzEhm5w=w1920-h1008-rw) <br /> 

#### Module configurations  <br />
![Module configurations](https://lh4.googleusercontent.com/hGIrchov0e2tp2fKTilxZIbzEYtNxdN6JGT-9Sm8SmsoFm1D7wkTT49ivmA5O44W5XguCT04Yw7rPA=w1920-h1008-rw) <br /> 
#### Page to import movies  <br />
![Page to import movies](https://lh4.googleusercontent.com/YaHcl4czORbpDK3fwJTUWe-3YPUkfyoqjQXNxFvVfeYkSH13lnc0vOAUh4MpcVW53-2AADXqKILjmQ=w1920-h1008-rw) <br /> 
#### Showing movies  <br />
![Showing movies](https://lh6.googleusercontent.com/8m9FwO9uh6uk34-vKSl8OedVPcA5ReXw_qePvwdIk6W9TCgG6S8kBWuZZ_Yhw9mR0kL6hCXKLt-OcQ=w1920-h1008-rw) <br />

#### _Add Favorite button_ on the product page  <br />
![_Add Favorite button_ on the product page](https://lh3.googleusercontent.com/JQzZ9ctPgC6yCNUVQMw5AWRsujyAviBzUgH4aycNQvILPGBfRV7ex1kHlZAwAY0llbtyeo6NYmgGwQ=w1920-h1008-rw) <br /> 

#### _Top 10 Favorite Movies_ page  <br />
![_Top 10 Favorite Movies_ page](https://lh5.googleusercontent.com/PTu7aYYdZtigcbkiaOu__o1RhZ8CyB3n7LS-i9_Gu7vand4VPcyeODAFJRLKHl-pBHjd_EvVLNuudw=w1920-h1008-rw) <br /> 