<?php

class SearchLyrics extends VeonExtension {
	public $Certainty;
	public $ID;
	public $Lyrics;
	public $Artist;
	public $Track;
	public $Album;
	public $Year;
	public $TrackLength;
	public $TrackNumber;
	public $DiskNumber;
	
	protected $ParamArtist;
	protected $ParamTrack;
	protected $ParamAlbum;
	protected $ParamYear;
	protected $ParamTrackLength;
	protected $ParamTrackNumber;
	protected $ParamDiskNumber;
	
	public function run() {
		// In case people didn't realise, this is hard coded to implement Veon, not to return real lyrics.
		if ($this->ParamTrack == 'The Middle') {
			$this->Certainty = '.99';
			$this->Lyrics = "YOU'RE IN THE MIDDLE OF THE RIDE LAWLS\nSTUFF HERE TOO LAWL\n";
			$this->Artist = "Jimmy Eat World";
			return true;
		}
		// Looks like no possible tracks were found.
		throw new Exception('No tracks found');
		return false;
	}
}
