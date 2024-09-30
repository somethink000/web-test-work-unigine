# README #

This is a test work from Web Department of Unigine Company.

### How do I get set up? ###

* Install Docker Compose
* Install Git
* Clone this repository
* Put ```127.0.0.1 url-shortener.loc``` into your hosts file
* Run ```docker-compose up``` in the root of the repository
* Go to ```http://url-shortener.loc``` in your browser

### How do I use it? ###

* To encode ```someurl``` you can use ```/encode-url?url=someurl``` endpoint
* To decode ```somehash``` you can use ```/decode-url?hash=somehash``` endpoint


### new features introduction ###

* Console command ```php bin/console send_url someurl 30-09-2024 ```
* Добавить ендпоинт, который не декодирует урл, а вместо результата редиректит пользователя на декодированный урл ```http://url-shortener.loc/find-url?hash={insert hash there}```
* на некоторый ендпоинт принимать информацию [урл/дата создания] ``` ```
* количество уникальных урлов за заданный промежуток времени ```http://url-shortener.loc/getstat-url?from=27-09-2024&to=now```
* количество уникальных урлов с указанным доменом ```http://url-shortener.loc/getdomin-url?domain=someurl  ```


