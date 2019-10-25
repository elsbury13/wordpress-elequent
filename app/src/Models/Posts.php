<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Eloquent\Model as Eloquent;

class Posts extends Eloquent
{
    protected $table = 'swiftsc_posts';

    public function getPages()
    {
        $pages = Posts::selectRaw('*, CONCAT(SUBSTRING_INDEX(guid,"?", 1), post_name) AS url')
                ->where('post_type', '=', 'page')
                ->get();

        if (!empty($pages)) {
            foreach ($pages as $page) {
                $page['post_content'] = preg_replace(
                    '/\[.*\]/',
                    '',
                    $page['post_content']
                );
            }
        }

        return $pages;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getPage($id)
    {
        $page = Posts::selectRaw('*, CONCAT(SUBSTRING_INDEX(guid,"?", 1), post_name) AS url')
                ->where('post_type', '=', 'page')
                ->where('ID', '=', $id)
                ->first();

        if (!empty($page)) {
            $page['post_content'] = preg_replace(
                '/\[.*\]/',
                '',
                $page['post_content']
            );
        }

        return $page;
    }

    public function getPosts()
    {
        $posts = Posts::selectRaw('*, CONCAT(SUBSTRING_INDEX(guid,"?", 1), post_name) AS url')
                ->where('post_type', '=', 'post')
                ->where('post_status', '=', 'publish')
                ->orderBy('ID', 'DESC')
                ->get();

        if (!empty($posts)) {
            foreach ($posts as $post) {
                $post['post_content'] = preg_replace(
                    '/\[.*\]/',
                    '',
                    $post['post_content']
                );
            }
        }

        return $posts;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getPost($id)
    {
        $post = Posts::selectRaw('*, CONCAT(SUBSTRING_INDEX(guid,"?", 1), post_name) AS url')
                ->where('post_type', '=', 'post')
                ->where('id', '=', $id)
                ->where('post_status', '=', 'publish')
                ->first();

        if (!empty($post)) {
            $post['post_content'] = preg_replace(
                '/\[.*\]/',
                '',
                $post['post_content']
            );
        }

        return $post;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getMenu($id)
    {
        $table = 'swiftsc_posts';
        $metaTable = 'swiftsc_postmeta';
        $relationshipTable = 'swiftsc_term_relationships';

        return Posts::selectRaw('ID, post_title, guid, post_name, CONCAT(SUBSTRING_INDEX(guid,"?", 1), post_name) AS url')
                ->join($metaTable, $metaTable . '.meta_value', '=', $table . '.ID')
                ->leftjoin($relationshipTable, $relationshipTable . '.object_id', '=', $metaTable . '.post_id')
                ->where($metaTable . '.meta_key', '=', '_menu_item_object_id')
                ->where($relationshipTable . '.term_taxonomy_id', '=', $id)
                ->get();
    }

    public function getLogo()
    {
        $table = 'swiftsc_posts';
        $metaTable = 'swiftsc_postmeta';

        return Posts::selectRaw('"logo" AS option_name, ' . $table . '.post_content as option_value')
                ->join($metaTable, $metaTable . '.post_id', '=', $table . '.ID')
                ->where($metaTable . '.meta_value', '=', 'custom-logo')
                ->orderBy($metaTable . '.meta_id', 'desc')
                ->first();
    }

    public function getPhoneDetails()
    {
        $phoneDetails = Posts::selectRaw('"phone" AS option_name, post_content AS option_value')
                ->where('post_title', '=', 'phone')
                ->orderBy('ID', 'desc')
                ->first();

        $phoneDetailsNumber = unserialize($phoneDetails['option_value']);
        $phoneDetails['option_value'] = '0' . explode('0', $phoneDetailsNumber['message'], 2)[1];

        return $phoneDetails;
    }
}
