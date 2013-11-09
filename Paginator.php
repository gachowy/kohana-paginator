<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana 3.x Pagination
 * @author Kamil 'gachowy' Kawka-Tomczak
 * @package kohana-paginator
 * @license http://wtfpl.net/about WTFPL
 * @link    http://kamilkt.pl                               Author's website
 * @link    http://github.com/gachowy/kohana-paginator 		GitHub
 * @version 0.1
 */

class Paginator {

	protected $query, $total_rows, $total_pages, $page, $per_page, $current_row, $url;


	/**
	 * Generates paginator object
	 * @param object $ORM_query ORM query
	 * @param int $page Current page
	 * @param int $rows_per_page Rows per page
	 * @param string $url_query URL query (why i need it?)
	 */

	public function __construct(ORM $ORM_query, $page=1, $rows_per_page=5, $url_query=NULL)
	{
		// Set query
		$this->query = clone($ORM_query);

		// Total rows
		$counting_query = clone($ORM_query);
		$this->total_rows = $counting_query->count_all();

		// Count total pages
		$this->total_pages = ceil($this->total_rows / $posts_per_page);

		// Set current page
		$this->page = $page;

		// Set rows per page
		$this->per_page = $rows_per_page;

		// Set current offset
		$this->current_row = $rows_per_page * ($page-1);

		// Set URL
		$this->url =URL::query(array('page' => $page));
	}

	/**
	 * Returns fetched rows
	 * @return object Fetched rows
	 */

	public function result()
	{
		// Fetching rows
		return $this->query
		->offset($this->current_row)
		->limit($this->per_page)
		->find_all();
	}

	/**
	 * Generates a paginator HTML code
	 * @return mixed Rendered HTML code
	 */

	public function render()
	{	
		$view = View::factory('paginator/paginator');
		$view->page = $this->page;
		$view->total_pages = $this->total_pages;
		$view->url = $this->url;
		return $view->render();
	}
}
