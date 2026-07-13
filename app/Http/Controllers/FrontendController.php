<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\CommitteeMember;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Player;
use App\Models\Post;
use App\Models\Result;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Slider;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Exception;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Frontend Controller for public-facing website pages.
 *
 * Handles rendering of all frontend views with necessary data fetching
 * (homepage, pages, news, blogs, events, players, galleries, etc.).
 */
class FrontendController extends Controller
{
    /**
     * Display the homepage with featured content.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $runningEvent         = Event::where('status', 1)->latest()
            ->paginate(10);

        // $upcomingEvent        = Event::where('status', 1)
        //     ->where('type', 0)
        //     ->latest()
        //     ->paginate(15);

        $about_mission_vision = Section::where('name', 'about_mission_vision')->first();

        $blogs                = Blog::where('status', "1")->latest()->paginate(7);

        $topNews              =  News::where('featured', 1)->where('status', '1')->orderBy('updated_at', 'desc')->paginate(5);

        $gamesNews            = News::getGamesNews();

        $slides               = Slider::where('key', 'banner_section')
            ->where('enabled', 1)
            ->orderBy('order')
            ->get();

        return view('home', compact(
            'runningEvent',
            'about_mission_vision',
            'blogs',
            'topNews',
            'gamesNews',
            'slides'
        ));
    }

    /**
     * Display a static page by slug.
     *
     * Special handling for contact and sports pages.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function pageDetails($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        if ($slug === 'contact-us') {
            return view('contact', compact('page'));
        }

        if ($slug === 'sports') {
            $sports = Post::where('status', 1)->paginate(10);
            return view('pages.details', compact('page', 'sports'));
        }

        return view('pages.details', compact('page'));
    }

    /**
     * Display match fixtures (notices of type 1).
     *
     * @return \Illuminate\View\View
     */
    public function matchFixtures()
    {
        $matchFixtures = Notice::where('type', 1)
            ->where('status', 1)
            ->latest()
            ->paginate(12);

        return view('match-fixtures', compact('matchFixtures'));
    }

    /**
     * Display general notice board (notices of type 0).
     *
     * @return \Illuminate\View\View
     */
    public function noticeBoard()
    {
        $notice = Notice::where('type', 0)
            ->where('status', 1)
            ->latest()
            ->paginate(12);

        return view('notice-board', compact('notice'));
    }

    /**
     * Display tournament results.
     *
     * @return \Illuminate\View\View
     */
    public function tournamentResult()
    {
        $results = Result::where('status', 1)->latest()->paginate(12);

        return view('tournament-result', compact('results'));
    }

    /**
     * Display gallery listing.
     *
     * @return \Illuminate\View\View
     */
    public function gallery()
    {
        $gallery = Gallery::where('status', 1)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('gallery.gallery', compact('gallery'));
    }

    /**
     * Display details of a specific gallery with its images.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function galleryDetails($id)
    {
        $gallery = Gallery::with('details')->findOrFail($id);
        $details = $gallery->details()->orderBy('sort_order')->paginate(20);

        return view('gallery.gallery-details', compact('gallery', 'details'));
    }

    /**
     * Display all news and updates.
     *
     * @return \Illuminate\View\View
     */
    public function newsAndUpdates()
    {
        $pageTitle = 'News and Updates';
        $news      = News::where('status', 1)->latest()->paginate(12);

        return view('news.news-and-updates', compact('news', 'pageTitle'));
    }

    /**
     * Display spotlight news.
     *
     * @return \Illuminate\View\View
     */
    public function spotlightNews()
    {
        $news      = News::getSpotlightNews();
        $pageTitle = 'Spotlights';

        return view('news.news-and-updates', compact('news', 'pageTitle'));
    }

    /**
     * Display single news/article details.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function newsAndUpdatesDetails($slug)
    {
        $news = News::where('status', 1)->where('slug', $slug)->firstOrFail();

        return view('news.news-and-updates-details', compact('news'));
    }

    /**
     * Display blog listing.
     *
     * @return \Illuminate\View\View
     */
    public function blogs()
    {
        $blogs = Blog::where('status', '1')->latest()->paginate(12);

        return view('blog.blogs', compact('blogs'));
    }

    /**
     * Display single blog post details.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function blogsDetails($slug)
    {
        $blog = Blog::where('status', '1')->where('slug', $slug)->firstOrFail();

        return view('blog.blog-details', compact('blog'));
    }

    /**
     * Display paginated list of active players.
     *
     * @return \Illuminate\View\View
     */
    public function players()
    {
        $pageTitle = 'Players';
        $players   = Player::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('players.index', compact('players', 'pageTitle'));
    }

    /**
     * Display details of a single player.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function playerDetails($slug)
    {
        $pageTitle = 'Player Details';
        $player    = Player::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('players.details', compact('player', 'pageTitle'));
    }

    /**
     * Display running (ongoing) events.
     *
     * @return \Illuminate\View\View
     */
    public function runningEvents()
    {
        $events = Event::where('type', '1')
            ->where('status', 1)
            ->latest()
            ->paginate(12);

        return view('events.running', compact('events'));
    }

    /**
     * Display upcoming events.
     *
     * @return \Illuminate\View\View
     */
    public function upcomingEvents()
    {
        $events = Event::where('type', 0)
            ->where('status', '1')
            ->latest()
            ->paginate(12);

        return view('events.upcoming', compact('events'));
    }

    /**
     * Display details of a running event.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function runningEventsDetails($slug)
    {
        $event = Event::where('status', 1)->where('slug', $slug)->firstOrFail();

        return view('events.running-details', compact('event'));
    }

    /**
     * Display committee members ordered by display order.
     *
     * @return \Illuminate\View\View
     */
    public function committeeMembers()
    {
        $members = CommitteeMember::where('status', 1)
            ->orderBy('order')
            ->get();

        return view('ec-members.committee-members', compact('members'));
    }

    /**
     * Display details of a single committee member.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function committeeMembersDetails($slug)
    {
        $member = CommitteeMember::where('status', 1)->where('slug', $slug)->firstOrFail();
        return view('ec-members.details', compact('member'));
    }

    /**
     * Display posts under a specific category.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function postCategoryDetails($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts    = $category->posts()
            ->where('status', '1')
            ->latest()
            ->paginate(12);

        return view('sports.sports', compact('category', 'posts'));
    }

    /**
     * Display details of a single post/sport article.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function postDetails($slug)
    {
        $post = Post::where('status', '1')->where('slug', $slug)->firstOrFail();

        return view('sports.sports-details', compact('post'));
    }

    /**
     * Handle contact form submission with reCAPTCHA and dynamic mail configuration.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
   public function contactSubmit(Request $request)
    {
        $request->validate([
            'email'                => 'required|email',
            'subject'              => 'nullable|string|max:255',
            'description'          => 'required|string|max:1000',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $settings = Setting::whereIn('label', [
            'mail_protocol',
            'mail_address',
            'send_from',
            'smtp_host',
            'smtp_username',
            'smtp_password',
            'smtp_port',
            'smtp_timeout',
            'smtp_crypto',
        ])->pluck('value', 'label');

        try {
            $mail = new PHPMailer(true);

            $protocol = $settings['mail_protocol'] ?? 'smtp';

            if ($protocol === 'mail') {
                $mail->isMail();
            } else {
                $mail->isSMTP();
                $mail->Host       = $settings['smtp_host'] ?? 'localhost';
                $mail->SMTPAuth   = !empty($settings['smtp_username']);
                $mail->Username   = $settings['smtp_username'] ?? '';
                $mail->Password   = $settings['smtp_password'] ?? '';
                $mail->SMTPSecure = $settings['smtp_crypto'] ?: PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = (int) ($settings['smtp_port'] ?? 587);
                $mail->Timeout    = (int) ($settings['smtp_timeout'] ?? 30);
            }

            $mail->setFrom($settings['send_from'], 'Website Contact Form');
            $mail->addAddress($settings['mail_address'] ?? config('mail.from.address'));
            $mail->addReplyTo($request->email, $request->name ?? 'Website User');
            $mail->isHTML(true);
            $mail->Subject = $request->subject ?: 'Contact Form Submission';
            $mail->Body    = nl2br(e($request->description));

            $mail->send();

            ToastMagic::success('Message sent successfully!');
        } catch (Exception $e) {
            ToastMagic::error('Failed to send message. Please try again later.');
        }

        return back();
    }
}
