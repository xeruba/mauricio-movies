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
  * 'price' and 'stock' (these are the default values when creating a new product, but it can be changed on the screen whenever you create a new product).

## About the module
1. Integration with the Movies API (admin): the integration with the API is performed on the backend, through the same endpoint used to access the movies index page. But, the pagination was done using JavaScript;
1. Importing products (admin): An 'attribute_set' was created, which has the 'is_movie' attribute, used to represent products that are movies;
1. InstallSchema and InstallData (admin): in addition to InstallSchema for the creation of new product attributes, a new table has also been created in the database, which serves to maintain the data regarding the movies that have been saved as favorites by customers;
1. 'Add to favorites' button: was appended to the product view through the file “product.info.addto”;
1. Screen to view the top 10 favorite movies (admin): ui_components was used to create the table with the data.

## Screeshots
1. Custom admin navigation bar
![image](https://lh3.googleusercontent.com/JTFUW3WxUTbTzB7G4ibQsF1lboHjguBVE9TRv9m4MWjD2srSeqYpqhnXdIFx1TBBpQhYnYfQhGz8yQ=w1920-h1008-rw)
1. Module configurations
![image](https://lh4.googleusercontent.com/hGIrchov0e2tp2fKTilxZIbzEYtNxdN6JGT-9Sm8SmsoFm1D7wkTT49ivmA5O44W5XguCT04Yw7rPA=w1920-h1008-rw)
1. Page to import movies
![image](https://lh6.googleusercontent.com/q3Dc3xfYescvewtt6sn89uIaME8u7DzlZWvkZBs357kp9THCpaZ0fjpjIviW-8JnnR8BrF9sjmSrVw=w1920-h1008-rw)
1. Showing movies
![image](https://lh4.googleusercontent.com/nkISYuCoSyi5EtciM9NbOJOger7c9xgbfesU6lCVuUxYkjDZf-cNGdnu6SOt8ofcX6gcR1wZIR_l3A=w1920-h1008-rw)
1. _Add Favorite button_ on the product page
![image](https://lh3.googleusercontent.com/JQzZ9ctPgC6yCNUVQMw5AWRsujyAviBzUgH4aycNQvILPGBfRV7ex1kHlZAwAY0llbtyeo6NYmgGwQ=w1920-h1008-rw)
1. _Top 10 Favorite Movies_ page
![image](https://lh5.googleusercontent.com/PTu7aYYdZtigcbkiaOu__o1RhZ8CyB3n7LS-i9_Gu7vand4VPcyeODAFJRLKHl-pBHjd_EvVLNuudw=w1920-h1008-rw)