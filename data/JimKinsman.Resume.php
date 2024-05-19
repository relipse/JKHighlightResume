<?php
$r = [];
$r['name'] = 'James A Kinsman';
$r['jobTitle'] = 'Senior Web Developer';
$r['education'] = 'B.S. Computer Science from UMBC 2007 (3.19 gpa)';
$r['summary'] = 'To work in both front-end and/or back-end technologies. With front-end, I enjoy
making things as seamless for the user as possible, thinking through good user-experience. And with back-end, I enjoy making code clean and object-oriented and well-built for the long run.';
$r['skills'] = [
    'PHP' => ['self_rating'=> 9, 'date_start'=>'January 2008', 'date_end'=>'now', 'years'=>null, 'versions'=>[4,5,7,8],
        'sub_skills'=>[
            'Moodle'=> ['self_rating'=> 5, 'date_start'=>'July 2018', 'date_end'=>'July 2021'],
            'Laravel' => ['self_rating'=> 4, 'date_start'=>'', 'date_end'=>'', 'years'=>5, 'comments'=>'Built recurring donation section for handofhelp.com with Laravel and upgraded it'],
            'CodeIgniter' => ['self_rating'=> 5, 'date_start'=>'', 'date_end'=>'', 'years'=>5, 'comments'=>'Built store https://handofhelp.com/resources and maintain it'],
            'TinyMVC' => ['self_rating'=> 9, 'date_start'=>'2011-01-01', 'date_end'=>''],
            'Wordpress' => ['self_rating'=> 5, 'date_start'=>''],
            'WordPress Plugins' => ['self_rating'=> 4, 'date_start'=>'', 'date_end'=>'', 'years'=>3],
            'twig' => ['self_rating'=>7, 'date_start'=>'2023-01-02', 'date_end'=>'2024-04-26', 'years'=>null,],
            'osTicket'=>['self_rating'=>6, 'date_start'=>'2024-01-01', 'years'=>null,],
            'Drupal Install Profiles'=> ['self_rating'=>1,'years'=>0,],
            'Magento 1' => ['self_rating'=>1],
        ],
    ],
    'MySQL' => ['self_rating'=> 8, 'date_start'=>'2008-01-01', 'years'=>null],
    'SQLite' => ['self_rating'=> 7, 'date_start'=>'2008-01-01', 'years'=>null],

    'JavaScript' => ['self_rating'=> 8, 'date_start'=>'2008-01-01', 'years'=>null,
        'sub_skills'=>[
            'jQuery' => ['self_rating'=> 9, 'date_start'=>'2008-01-01', 'years'=>null]
        ]
    ],
    'Redis' => ['self_rating'=>6, 'years'=>2],
    'Elasticsearch' => ['self_rating'=>3, 'years'=>2],

    'HTML' => ['self_rating'=>9, 'date_start'=>'January 2003', 'date_end'=>'now'],
    'CSS' => ['self_rating'=> 9, 'date_start'=>'January 2004', 'sub_skills'=>['Sass'=> ['self_rating'=>4],
        'Less'=> ['self_rating'=>5],]
    ],
];
$r['condensedSkills'] = [
    'Docker'=> ['self_rating'=>4, 'years'=>1],
    'LAMP' => ['self_rating' => 9],
    'LEMP' => ['self_rating' => 4],
    'Apache' => ['self_rating' => 8],
    'Linux' => ['self_rating' => 6],
    'Jenkins' => ['self_rating' => 1],
    'Windows IIS' => ['self_rating' => 3],
    'C++' => ['self_rating' => 6],
    'C++Builder'=>['self_rating'=>6],
    'Delphi/Lazarus' => ['self_rating' => 2],
];

$r['hobbies'] = [
    'Chess (and Blitz) (U.S. Chess Federation Expert)',
    'Pickleball almost every day',
    'Video games with daughter (Lego, Overcooked)',
];

$r['highlights'] = [
    ['year'=>2003, 'text'=>'Because of prior C++ experience, I skipped past the C course and the next semester was hired as a tutor and after that, a teaching assistant (TA) for the <strong>UMBC Computer Science Department</strong>'],
    ['year'=>2006, 'text'=>'Worked for <strong>Lockheed Martin: Leading Aerospace and Defense</strong> as an Intern in Rockville, MD'],
    ['year'=>2007, 'text'=>'Graduated from <strong>University of Maryland, Baltimore County (UMBC)</strong> '],
    ['year'=>2008, 'text'=>'Instead of going through with an interview at Microsoft, joined a startup <a href="https://akubocrm.com" target="blank">AkuboCRM (akubocrm.com)</a> and wrote the main code for the organization from the ground up using PHP/MySQL and HTML/JavaScript/jQuery'],
    ['year'=>2009, 'text'=>'Started volunteering for <a target="_blank" href="https://handofhelp.com">Hand of Help (handofhelp.com)</a>, an organization located in Wisconsin using programming and Web Development skills to upscale their website, physical mailing list database, in-kind donations, customer store section, recurring donation section with Laravel and have been with them for {YEAR_DIFF} years as a contractor and am still with them.'],
];
//replace some templated stuff
foreach($r['highlights'] as &$h){
    $h['text'] = str_replace('{YEAR_DIFF}', (intval(date('Y')) - $h['year']), $h['text']);
}
unset($h);

//because I can't fit them all, we are just going to put some highlights
$r['experiences'] = [
    'Spring Systems'=>[
        'location' => 'Remote in VA then WI (company out of New York)',
        'title'=> 'Senior Developer',
        'date_start'=> 'Jan 2, 2023',
        'date_end'=> 'Apr 26, 2024',
        'list'=>[
            'Spent time learning custom massive codebase with tasks and debugging PHP working with coworker in Ukraine remotely. Sometimes in the debugger 5-6 hours a day.',
            'Used Symfony\'s twig and PHP to help generate emails to end-users that look pleasing and good for user-experience (UX) using style-driven html tags. Also coded a Table transformer that will accept html (for an email) and transform tables to be much better for the end user using dom manipulation in PHP (alternating row colors, numbered columns, sums, average)',
            'Used the Jira rest api to write a command-line script to change the status of my tickets and update ticket comments and grab the title and summary. Used Bitbucket API to programmatically create pull requests and list branches using a command-line script to speed up development time.',
        ],
    ],
    'Hampton Roads Transit' => [
        'location' => 'Hybrid - Norfolk, VA',
        'title' => 'Senior Web Developer',
        'date_start'=>'Oct 1, 2021',
        'date_end'=>'Dec 15, 2022',
        'list'=> [
            'Initiated Code Reviews, met with other managers of HRT to gather requirements, collaborated with Junior Web Developer and Technical manager',
            'Developed PHP applications and worked in WordPress, such as Am I Clean, an app where people at bus stops can scan QR code and report whether the stop had trash around and needed to be clean.'
        ]
    ],
    'Web Courseworks' => [
        'location' => 'Madison, WI then Remote',
        'title'=> 'Senior PHP Developer',
        'date_start'=>'July 23, 2018',
        'date_end'=>'July 23, 2021',
        'list'=> [
            'Worked with a team of around 15 developers with technologies such as PHP 5-PHP 7.4 Moodle 1.9-3.9, Soap, Rest, JavaScript in ES6, Grunt, Babel, ElasticSearch, Redis, Gearman, Linux (Ubuntu) Amazon Web Services (AWS)',
            'Fixed problematic sql-injection from junior developer that somehow passed code review.',
            'Upgraded Magento 1 from PHP 5 to PHP 7, upgraded our codebase from PHP 7.2 to PHP 7.4'
        ],
    ],
    'Hand of Help' => [
        'location' => 'Watertown, WI then Remote',
        'title' => 'Senior Web Developer (Contractor)',
        'date_start'=>'Mar 1, 2010',
        'date_end' => 'now',
        'list'=> [
            'Upgrade Sites from PHP 5.6 to PHP 8.1 Including Laravel 5.3 to Laravel 9.0 (Using Laravel Shift)',
            'Used Laravel to create a Recurring Donation Admin tool to manage recurring donations from donors.',
            'Created store section with shopping carts and orders, designed database, utilized existing tables. Used CodeIgniter and accepting Credit Cards.',
            'Converted desktop site to responsive design for mobile and tablet.',
            'Installed security logging of credit card transactions to deal with massive attacks from Brazil',
            'Coded central code-base to for our credit card system to be handled by forte for regular donations and recurring transactions.',
            'Used TinyMVC to build two back-end projects, one for keeping track of the physical mailing list, and the other to keep track of in-kind donations such as boxes and clothing items.',
        ]
    ],
];