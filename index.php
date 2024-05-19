<?php
/**
 * This file is part of JKHighlightResume
 *
 * (c) 2024 James Kinsman relipse@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.

 * @copyright 2024 Jim Kinsman
 * @license MIT
 */
use JKinsman\ResumeData;
use JKinsman\ResumeDisplay;
require_once(__DIR__.'/inc/autoloader.php');

try {
    $resumeData = new ResumeData(__DIR__ . '/data/JimKinsman.Resume.php');
} catch (Exception $e) {
    die("Resume data is invalid or doesn't exist");
}

$resume = new ResumeDisplay($resumeData);

if (isset($_GET['x7819uyfmajf2083jf'])) {
    $resume->showContactInfo(true);
}else{
    $resume->showContactInfo(false);
}
$stylesVersion = date('Y-m-d_H-i-s', filemtime(__DIR__.'/styles.css'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $resume->personName() ?> | <?= $resume->jobTitle() ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles.css?<?= $stylesVersion ?>" rel="stylesheet">
    <meta name="description" content="Resume for <?=$resume->personName()?>">
    <meta name="author" content="<?=$resume->personName()?>">
</head>
<body>
<h1><?= $resume->personName() ?> | <?= $resume->jobTitle() ?> | <?= $resume->getYearsExperience('Jan 1, 2008', 'now') ?>
    Years Experience</h1>
<div class="edu_and_skills flex-item">
    <div class="education">
        <h2>Education</h2>
        <?= $resume->education()."\n"?>
    </div>
    <div class="skills">
        <h2>Skills</h2>
        <h3>(self-rating x/10)</h3><?="\n".
        $resume->skillsToHtmlList($resume->skills(), ['hide_sub_years' => true], 0, 2); ?>
        <?="\n". $resume->skillsToHtmlList($resume->condensedSkills(), ['class' => 'condensed'], 0, 2)."\n" ?>
    </div>
    <div class="hobbies">
        <h2>Hobbies</h2>
        <?= $resume->hobbiesToHtmlList(null,[],2)."\n" ?>
    </div>
</div>
<div class="summary_and_achievements flex-item">
    <div class="summary">
        <h2>Professional Ambitions</h2>
        <?= $resume->summary() ?>
    </div>
    <div class="highlights">
        <h2>Achievements</h2>
        <?= $resume->highlightsToHtmlList(false, 2) ?>
    </div>
</div>
<div class="experience flex-item">
    <h2>Career Highlights</h2>
    <?= $resume->experiencesToHtmlList(1)."\n" ?>
</div>
<footer>
    <div class="contact">
        <?= $resume->phoneEmailSocialLinksIfExists(true)."\n"?>
    </div>
    <div class="other">
        Work History or References provided upon request. This resume was created by me using: PHP, HTML and CSS.
    </div>
</footer>
<!-- If you see this, you should hire me :) This resume was created in PHP and condensed to print on 1 page. -->
</body>
</html>
