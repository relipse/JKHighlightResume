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

class ResumeData {
    protected string $filepath = '';
    protected string $ext = '';
    protected array $data = [];
    //Right now, this is all the data that is allowed:
    protected array $whitelist = ['name', 'contactPhone', 'contactEmail', 'linkedIn', 'github', 'jobTitle', 'summary', 'education', 'skills', 'condensedSkills', 'hobbies', 'highlights', 'experiences'];

    /**
     * Initializes a new instance of the class.
     *
     * @param string $filepath The path to the resume data file.
     *
     * @throws \Exception If the resume data file does not exist, is empty,
     *                    does not contain the right $r variable, or has
     *                    an unsupported file type (extension).
     */
    public function __construct(string $filepath, string $privatepath = ''){
        if (!file_exists($filepath)) {
            throw new \Exception('Resume data file does not exist: '. $filepath);
        }
        $this->filepath = $filepath;
        $this->ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
        if ($this->ext === 'php') {
            $r = [];
            include($filepath);
            if (empty($r)) {
                throw new \Exception('Resume data file is empty or does not contain right $r variable: ' . $filepath);
            }
            if (empty($privatepath)) {
                $basename = pathinfo($filepath, PATHINFO_BASENAME);
                $basename = strstr($basename, '.', true);
                $privatepath = pathinfo($filepath, PATHINFO_DIRNAME) . '/../private/' . $basename . '.json';
            }
            if (file_exists($privatepath)) {
                //now get private sensitive data
                $prv = json_decode(file_get_contents($privatepath), true);
                if (!empty($prv)) {
                    $r = array_merge($r, $prv);
                }
            }
            $this->data = $r;
        }else{
            throw new \Exception('Resume data file type (extension) is not supported: '. $this->ext);
        }
    }

    /**
     * Get the resume data.
     *
     * @return array The resume data.
     */
    public function getData() : array {
        return $this->data;
    }

    /**
     * Retrieves the value of a specific data key.
     *
     * @param string $key The key of the data value to retrieve.
     *
     * @return mixed|null The value of the data key, or null if the key does not exist.
     *
     * @throws \Exception If the key is not whitelisted.
     */
    public function getDataValue(string $key) {
        if (!in_array($key, $this->whitelist)) {
            throw new \Exception("Invalid property: $key");
        }
        return $this->data[$key] ?? null;
    }

    /**
     * Magic method to retrieve data value by key.
     *
     * @param string $key The key to retrieve the data value.
     *
     * @return mixed The data value associated with the specified key.
     */
    public function __get($key) {
        return $this->getDataValue($key);
    }
}