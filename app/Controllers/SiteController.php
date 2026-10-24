<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Course;
use App\Models\Job;
use App\Models\Post;
use App\Models\Resource;

/**
 * The public pages whose content staff manage in the admin area.
 */
final class SiteController extends Controller
{
    public function media(): void
    {
        $type = (string)Request::input('type', '');
        if (!isset(Post::TYPES[$type])) {
            $type = '';
        }
        $this->view('public/media', [
            'posts' => (new Post())->published($type === '' ? null : $type),
            'type'  => $type,
        ], 'site');
    }

    public function post(string $slug): void
    {
        $post = (new Post())->findPublishedBySlug($slug);
        if ($post === null) {
            $this->fail(404, 'That story could not be found. It may have been moved or unpublished.', 'site');
        }
        $this->view('public/post', ['post' => $post], 'site');
    }

    public function toolkits(): void
    {
        $this->view('public/toolkits', ['groups' => (new Resource())->publishedByCategory()], 'site');
    }

    public function jobs(): void
    {
        $this->view('public/jobs', ['jobs' => (new Job())->open()], 'site');
    }

    public function training(): void
    {
        $this->view('public/training', ['courses' => (new Course())->published()], 'site');
    }
}
