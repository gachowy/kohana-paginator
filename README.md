kohana-paginator
================

Simple pagination class for Kohana 3.x

Alpha version


Example
================

```php
$posts = ORM::factory('Post')->where('public', '=', 1)

$paginator = new Paginator($posts, 1, 10);

$view = View::factory('posts/list');
$view->posts = $paginator->result();
$view->pagination = $paginator->render();

$this->response->body($view->render());
```