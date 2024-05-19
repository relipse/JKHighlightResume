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
namespace JKinsman;
use \DateTime;
use \Throwable;

class ResumeDisplay
{
    protected array $skills = [];
    protected array $condensedSkills = [];
    protected string $personName = '';
    protected string $jobTitle = '';
    protected string $summary = '';
    protected string $education = '';
    protected string $contactEmail = '';
    protected string $contactPhone = '';

    protected string $linkedInUrl = '';
    protected string $githubUrl = '';

    protected array $highlights = [];
    protected array $experiences = [];

    protected array $hobbies = [];

    protected bool $showContactInfo = false;

    protected int $indentNumSpaces = 4;

    public function __construct(ResumeData $resumeData){
        $this->hobbies = $resumeData->hobbies;
        $this->skills = $resumeData->skills;
        $this->condensedSkills = $resumeData->condensedSkills;
        $this->personName = $resumeData->name;
        $this->education = $resumeData->education;
        $this->highlights = $resumeData->highlights;
        $this->jobTitle = $resumeData->jobTitle;
        $this->summary = $resumeData->summary;
        $this->experiences = $resumeData->experiences;
        $this->contactPhone = $resumeData->contactPhone;
        $this->contactEmail = $resumeData->contactEmail;
        $this->linkedInUrl = $resumeData->linkedIn;
        $this->githubUrl = $resumeData->github;
    }

    public function showContactInfo(bool $b){
        $this->showContactInfo = $b;
    }

    public function condensedSkills(): array
    {
        return $this->condensedSkills;
    }

    public function skills(): array
    {
        return $this->skills;
    }

    public function experiences(): array
    {
        return $this->experiences;
    }

    public function education(): string
    {
        return $this->education;
    }

    public function personName(): string
    {
        return $this->personName;
    }

    public function jobTitle(): string
    {
        return $this->jobTitle;
    }

    public function summary(): string
    {
        return $this->summary;
    }

    public function setLinkedInUrl(string $linkedInUrl): void
    {
        $this->linkedInUrl = $linkedInUrl;
    }

    public function setGithubUrl(string $githubUrl): void
    {
        $this->githubUrl = $githubUrl;
    }

    public function setContactPhone(string $phone)
    {
        $this->contactPhone = $phone;
    }

    public function setContactEmail(string $email)
    {
        $this->contactEmail = $email;
    }

    public function contactEmail(): string
    {
        return $this->contactEmail;
    }

    public function contactPhone(): string
    {
        return $this->contactPhone;
    }

    public function phoneEmailSocialLinksIfExists($htmlize = false): string
    {
        if (!$this->showContactInfo){
            return '';
        }
        $s = '';
        $p = $this->contactPhone;
        if (!empty($this->contactEmail)) {
            if (!empty($p)) {
                if ($htmlize) {
                    $s .= '<a href="tel:' . preg_replace('/\D/', '', $p) . '">';
                }
                $s .= $p;
                if ($htmlize) {
                    $s .= '</a>';
                }
                $s .= ' | ';
            }
            if ($htmlize) {
                $s .= '<a href="mailto:' . $this->contactEmail . '?subject=I%20saw%20your%20resume">';
            }
            $s .= $this->contactEmail;
            if ($htmlize) {
                $s .= '</a>';
            }
        }
        if (!empty($s)) {
            if ($htmlize) {
                $social = $this->socialLinksHtml();
            } else {
                $social = '';
            }
            if (!empty($social)) {
                $s .= ' | ' . $social;
            }
        }
        return $s;
    }

    public function socialLinksHtml(): string
    {
        $html = '';
        $html .= $this->getLinkedInLinkHtml();
        if (!empty($html) && !empty($this->githubUrl)) {
            $html .= ' | ';
        }
        $html .= $this->getGithubLinkHtml();
        return $html;
    }

    public function getLinkedInLinkHtml(): string
    {
        return $this->getLinkHtml($this->linkedInUrl);
    }

    public function getLinkHtml(string $fullUrl): string
    {
        if (preg_match('#^https?://#', $fullUrl) === 0) {
            //not a valid url
            return '';
        }
        return '<a href="' . $fullUrl . '" target="_blank">' . preg_replace('#https?://(www\.)?#', '', $fullUrl) . '</a>';
    }

    public function getGithubLinkHtml(): string
    {
        return $this->getLinkHtml($this->githubUrl);
    }

    public function experiencesToHtmlList(int $indentLevel = 0): string
    {
        if (empty($this->experiences)) {
            return '';
        }
        $html = '';
        $html .= $this->indent($indentLevel);
        $html = '<ul class="experiences" data-indent="' . $indentLevel . '">';
        foreach ($this->experiences as $company => $exp) {
            if (empty($exp['text']) && empty($exp['list'])) {
                continue;
            }
            $html .= "\n";
            $html .= $this->indent($indentLevel + 1);
            $html .= '<li>';

            if (isset($exp['date_start'])) {
                $html .= '<span class="dates"><span class="date_start">' . $this->stringToPrettyDateString($exp['date_start'], 'Y') . '</span>';

                if (isset($exp['date_end'])) {
                    if ($exp['date_end'] === 'now') {
                        $endYearStr = 'Current';
                    } else {
                        $endYearStr = $this->stringToPrettyDateString($exp['date_end'], 'Y');
                    }
                    $html .= '-<span class="date_end">' . $endYearStr . '</span> ';
                }
                $html .= '</span>';
            }
            $html .= ' <span class="company">';
            if (!empty($exp['title'])) {
                $html .= ' <span class="title">' . $exp['title'] . '</span> | ';
            }
            $html .= $company;

            if (!empty($exp['location'])) {
                $html .= ' - <span class="location">' . $exp['location'] . '</span>';
            }

            $html .= '</span>: ';

            if (!empty($exp['text'])) {
                $html .= $exp['text'];
            }
            if (!empty($exp['list'])) {
                $html .= "\n";
                $html .= $this->indent($indentLevel + 1);
                $html .= '<ul class="experience-list">' . "\n";
                foreach ($exp['list'] as $item) {
                    $html .= $this->indent($indentLevel + 2) . '<li>' . $item . '</li>' . "\n";
                }
                $html .= $this->indent($indentLevel + 1);
                $html .= '</ul>' . "\n";
            }
            $html .= $this->indent($indentLevel + 1);
            $html .= '</li>' . "\n";
        }
        $html .= $this->indent($indentLevel);
        $html .= '</ul>';
        return $html;
    }

    public function stringToPrettyDateString(string $date, string $format = 'M j, Y'): ?string
    {
        if (empty($date)) {
            return '';
        }
        $dt = $this->stringToDate($date);
        if (empty($dt)) {
            return '';
        }
        return $dt->format($format);
    }

    public function stringToDate(string $date): ?DateTime
    {
        try {
            return new DateTime($date);
        } catch (Throwable $t) {
            //echo $t->getMessage();
            return null;
        }
    }

    public function indent(int $level, string $char = ' '): string
    {
        if (empty($level)) {
            return '';
        }
        $s = '';
        $numSpaces = $level * $this->indentNumSpaces;
        for ($i = 0; $i < $numSpaces; $i++) {
            $s .= $char;
        }
        return $s;
    }

    public function highlightsToHtmlList(bool $numbered = true, int $indent = 0, int $initialIndent = 0): string
    {
        $html = '';
        if (!empty($this->highlights)) {
            $html .= $this->indent($initialIndent);
            $html .= '<' . ($numbered ? 'ol' : 'ul') . ' class="highlights" data-indent="' . $indent . '" data-initial-indent="' . $initialIndent . '">';
            foreach ($this->highlights as $highlight) {
                $endYear = '';
                if (!empty($highlight['end_year'])) {
                    if ($highlight['end_year'] == 'now') {
                        $highlight['end_year'] = date('Y');
                    }
                    $years = $this->getYearsExperience('Jan 1, ' . $highlight['year'], 'Jan 1, ' . $highlight['end_year']);
                    if ($years !== 1) {
                        $years .= ' yrs';
                    } else {
                        $years .= 'yr';
                    }

                    $endYear .= '-';
                    if ($highlight['end_year'] == 'now') {
                        $endYear .= 'Current';
                    } else {
                        $endYear .= date('Y', strtotime('Jan 1, ' . $highlight['end_year']));
                    }
                    $endYear .= ' ' . $years;
                }
                $html .= "\n";
                $html .= $this->indent($initialIndent + $indent + 1);
                $html .= '<li><strong>' . $highlight['year'] . $endYear . '</strong> - ' . $highlight['text'];

                //$html .= "\n";
                //$html .= $this->indent($initialIndent+$indent);
                $html .= '</li>' . "\n";
            }
            $html .= $this->indent($initialIndent + $indent);
            $html .= '</' . ($numbered ? 'ol' : 'ul') . '>';
            $html .= "\n";
        }
        return $html;
    }

    public function getYearsExperience(string $fromDate, string $toDate): int
    {
        if (empty($fromDate) || empty($toDate)) {
            return 0;
        }
        $from = $this->stringToDate($fromDate);
        $to = $this->stringToDate($toDate);

        if (empty($from) || empty($to)) {
            return 0;
        }

        $diff = $to->diff($from);

        return $diff->y;
    }

    public function skillsToHtmlList(?array $skills = null, array $opts = [], int $indentLevel = 0, $initialIndentLevel = 0): string
    {
        $ul_or_ol = !empty($opts['ol']) ? 'ol' : 'ul';
        $hideSubYears = isset($opts['hide_sub_years']);
        $skills ??= $this->skills;
        $class = $opts['class'] ?? '';
        if (!empty($class)) {
            $class .= ' ';
        }

        if (empty($skills)) {
            return '';
        }

        $html = '';
        if ($indentLevel > 0) {
            $html .= "\n";
        }
        if ($indentLevel > 0 || $initialIndentLevel > 0) {
            $html .= $this->indent($initialIndentLevel + $indentLevel);
            //$html .= $this->indent($indentLevel);
        }
        uasort($skills, function ($a, $b) {
            if (empty($b['self_rating'])) {
                $b['self_rating'] = 0;
            }
            if (empty($a['self_rating'])) {
                $a['self_rating'] = 0;
            }
            return $b['self_rating'] <=> $a['self_rating'];
        });
        $html .= "<$ul_or_ol class=\"" . $class . "skills" . ($indentLevel > 0 ? ' sub' : '') . "\" data-indent=\"" . $indentLevel . "\" data-initial-indent=\"$initialIndentLevel\">\n";
        foreach ($skills as $skill => $skill_detail) {
            $d = $this->arraySkillsToViewableDetails($skill_detail);
            $selfRatingStr = is_numeric($d['self_rating']) ? ' (<span class="self-rating">' . $d['self_rating'] . '</span>/10)' : '';
            if ($initialIndentLevel > 0) {
                $html .= $this->indent($initialIndentLevel);
            }
            $html .= $this->indent($indentLevel + 1);
            $html .= '<li class="skill" data-indent="' . $indentLevel . '">' . $skill . $selfRatingStr;

            $showYears = !empty($d['years']);
            if ($indentLevel > 0 && $hideSubYears) {
                $showYears = false;
            }

            if ($showYears) {
                $html .= " {$d['years']}";
                $html .= " yr";
                if ($d['years'] != 1) {
                    $html .= 's';
                }
            }
            if (!empty($skill_detail['sub_skills'])) {
                $html .= $this->skillsToHtmlList($skill_detail['sub_skills'], $opts, $indentLevel + 1, $initialIndentLevel);
            }
            $html .= "</li>\n";
        }
        $html .= $this->indent($indentLevel + $initialIndentLevel);
        $html .= "</$ul_or_ol>";
        return $html;
    }

    protected function arraySkillsToViewableDetails(array $details): array
    {
        $self_rating = $details['self_rating'] ?? '';
        $date_start = $this->stringToPrettyDateString($details['date_start'] ?? '');
        if (empty($details['date_end']) && !empty($date_start)) {
            $details['date_end'] = 'now';
        }
        $date_end = $this->stringToPrettyDateString($details['date_end'] ?? '');
        $yearsExperience = $this->getYearsExperience($date_start, $date_end);
        if (empty($yearsExperience)) {
            $yearsExperience = $details['years'] ?? '';
        }
        if (empty($yearsExperience)) {
            $yearsExperience = '';
        }
        return ['self_rating' => $self_rating, 'date_start' => $date_start, 'date_end' => $date_end, 'years' => $yearsExperience];
    }

    public function hobbiesToHtmlList(?array $hobbies = null, array $opts = [], int $indentLevel = 0): string
    {
        if (is_null($hobbies)) {
            $hobbies = $this->hobbies;
        }
        if (empty($hobbies)) {
            return '';
        }
        $html = '';
        //The calling function should start at the proper indent.
        //$html .= $this->indent($indentLevel);
        $html .= '<ul class="hobbies">' . "\n";
        foreach ($hobbies as $hobby => $text) {
            $html .= $this->indent($indentLevel + 1);
            $html .= '<li>' . $text . '</li>' . "\n";
        }
        $html .= $this->indent($indentLevel);
        $html .= '</ul>';
        return $html;
    }

    public function skillsToHtmlTable($opts = []): string
    {
        $skills = $this->skills;

        $html = "<table>\n";

        $html .= "<tr><th>Skill</th><th>Self Rating<br>10 is best</th>";

        if (isset($opts['show_dates'])) {
            $html .= "<th>Start Date</th><th>End Date</th>";
        }

        $html .= "<th>Years</th>";
        if (isset($opts['show_comments'])) {
            $html .= "<th>Comments</th>";
        }
        if (isset($opts['show_versions'])) {
            $html .= "<th>Versions</th>";
        }
        $html .= "</tr>\n";
        $html .= $this->subSkillsToHtmlTableRow($skills, 0);
        $html .= "</table>\n";

        return $html;
    }

    public function subSkillsToHtmlTableRow(?array $sub_skill_details, int $indentLevel = 0, array $opts = []): string
    {
        if (empty($sub_skill_details)) {
            return '';
        }
        $html = '';
        uasort($sub_skill_details, function ($a, $b) {
            return $b['self_rating'] <=> $a['self_rating'];
        });
        foreach ($sub_skill_details as $sub_skill => $sub_skill_detail) {
            $d = $this->arraySkillsToViewableDetails($sub_skill_detail);

            $html .= "<tr class='sub-skill'><td class='subskill' style='padding-left: " . ($indentLevel * 6) . "px;'>$sub_skill</td><td class='self-rating'>{$d['self_rating']}</td>";

            if (isset($opts['show_dates'])) {
                $html .= "<td>{$d['date_start']}</td><td>{$d['date_end']}</td>";
            }

            $html .= "<td>{$d['years']}</td>";

            $html .= $this->subSkillsToHtmlTableRow($sub_skill_detail['sub_skills'] ?? null, $indentLevel + 1);
        }
        return $html;
    }
}
