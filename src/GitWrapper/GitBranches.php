<?php

/**
 * A PHP wrapper around the Git command line utility.
 *
 * @mainpage
 *
 * @license GNU General Public License, version 3
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see https://github.com/cpliakas/git-wrapper
 * @copyright Copyright (c) 2013 Acquia, Inc.
 */

namespace GitWrapper;

/**
 * Class that parses and returnes an array of branches.
 */
class GitBranches
{

	/**
	 * The working copy that branches are being collected from.
	 *
	 * @var GitWorkingCopy
	 */
	protected $git;


	/**
	 * Constructs a GitBranches object.
	 *
	 * @param GitWorkingCopy $git
	 *   The working copy that branches are being collected from.
	 */
	public function __construct(GitWorkingCopy $git)
	{
		$this->git = clone $git;
	}


	/**
	 * Fetches the branches via the `git branch` command.
	 *
	 * @param boolean $only_remote
	 *   Whether to fetch only remote branches, defaults to false which returns
	 *   all branches.
	 *
	 * @return array
	 */
	public function fetchAllBranches()
	{
		$this->git->clearOutput();
		$options = array('a' => true);
		$output = (string) $this->git->branch($options);
		$branches = preg_split("/\r\n|\n|\r/", rtrim($output));
		return array_map(array($this, 'trimBranch'), $branches);
	}


	/**
	 * Fetches the branches via the `git branch` command.
	 *
	 * @param boolean $only_remote
	 *   Whether to fetch only remote branches, defaults to false which returns
	 *   all branches.
	 *
	 * @return array
	 */
	public function fetchRemoteBranches()
	{
		$this->git->clearOutput();
		$options = array('r' => true);
		$output = (string) $this->git->branch($options);
		$branches = preg_split("/\r\n|\n|\r/", rtrim($output));
		return array_map(array($this, 'trimBranch'), $branches);
	}


	/**
	 * Fetches the branches via the `git branch` command.
	 *
	 * @param boolean $only_remote
	 *   Whether to fetch only remote branches, defaults to false which returns
	 *   all branches.
	 *
	 * @return array
	 */
	public function fetchLocalBranches()
	{
		$this->git->clearOutput();
		$output = (string) $this->git->branch();
		$branches = preg_split("/\r\n|\n|\r/", rtrim($output));
		return array_map(array($this, 'trimBranch'), $branches);
	}


	/**
	 * Strips unwanted characters from the branch.
	 *
	 * @param string $branch
	 *   The raw branch returned in the output of the Git command.
	 *
	 * @return string
	 *   The processed branch name.
	 */
	public function trimBranch($branch)
	{
		return ltrim($branch, ' *');
	}


}


