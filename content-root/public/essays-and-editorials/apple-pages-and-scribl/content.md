# Publishing to Scribl

{!! dateblock !!}

> The specific equipment listed is not *required*. The listed capabilities are more important.

## EPUB

What you'll need:

1. Access to word processing with the ability to export to the [EPUB format](https://en.wikipedia.org/wiki/EPUB) directly or in a format that converted that format.
	- We'll [Apple Pages](https://www.apple.com/pages/), available on multiple Apple devices.
2. An [.EPUB](electronic publication) editor. 
	- We'll use [Calibre](https://calibre-ebook.com) because that seems to be what [Scribl](https://www.scribl.com) uses for their quality checks.
3. Image editing software to create a cover image 1680 pixels wide by 2520 pixels tall (6" x 9" at 300dpi).
	- We'll use [Affinity Designer](https://affinity.serif.com/en-us/designer/).

Creating the EPUB:

1. Create a document in Apple Pages.
	- It should use a table of contents for these instructions.
	- Use a single font family throughout; you don't control the fonts users will use for the EPUB version.
	- Do not add the cover image to the first page of the EPUB.
2. Export to EPUB: File > Export to... > EPUB...
	- A dialog box should appear.
3. Enter the correct information:
	- Title: The title as it will appear in the library of the e-reader.
	- Author: The name of the author as it will appear in the e-reader.
	- Cover: The cover image that appears in the library of the e-reader.
		- Choose the cover image.
	- Layout: How text will flow on different devices.
		- Choose "Reflowable."
	- Advanced options:
		- Category: A category for the book (I'm not sure what platforms support the Apple implementation of this functionality).
		- Language: Choose the appropriate language for the text.
		- Use table of contents: Make sure this is checked.
		- Embed fonts: Leave this unchecked; we'll remove all references to your fonts in a minute.
			- This also reduces the overall download size of the book because the fonts won't be included.
4. Save the file.

Post-process the EPUB:

1. [Right-click](https://support.apple.com/guide/mac-help/right-click-mh35853/mac) on the file > Open with > ebook-edit
	- Try not to be too intimidated by all the files.
2. In the top menu, you should see multiple icons.
3. Click Check Book (the bug icon).
	- The editor should run some checks.
	- Any errors and warnings should appear in the window's left pane.
4. Fix errors (unless otherwise instructed, double-click the entry, correct the error, and return to step 3—that specific error should no longer appear in the list):
	- Empty block in [.CSS](cascading stylesheet) file: Highlight from the dot (.) the closing curly bracket (}) > Delete the text > Save the file.
		- A block is made up of a name (selector) starting with a period (.), followed by an opening curly brackets ({), followed by a closing curly brackets (}). Between the opening and closing curly brackets may be a set of attributes. The block is considered empty if there is nothing between the opening and closing curly brackets. Empty blocks mean that the block is either not used or does not actually change the look and feel of the EPUB book. Therefore, you can delete the block without a negative impact.
	- Missing generic font family: Remove all references to `font-family: ...`; recommend:
		1. Select the point after the semicolon (;) on the previous line until the end of the font family definition.
		2. Copy this text.
		3. `Command + F`
		4. Paste the text into the Find field.
		5. Click "Replace all".
		6. Click "See what changed".
		7. Confirm that each referent to a font family was removed. If something is incorrect, click "Revert changes"; otherwise, click "Close."
		8. Save the `book.css` file.
		9. Redo step 4, which may require fixing more generic font family problems.
	- Expected selector "a" to come before:
		1. Double-click the error
		2. Scroll to the top of the CSS file (all of these should be near the top)
		3. Highlight the "a" all the way to the closing curly bracket
		4. Cut the text
		5. Place the cursor as the first character
		6. Paste the text
		7. Hit return to add a line break after the closing curly bracket.
		8. Save the file.
		9. Redo step 4.
	- OPS/epb.opf (icon of a human slipping): Click "Try to correct all fixable errors automatically.
	- User controls background color: If you did not set the background color for the view, you should not have an explicit text color either. Apple Pages does not have an "automatic" font color option. Therefore, we want to remove any explicit color settings that will appear on the user-defined background.
		1. Find the CSS attribute `color:`. If the attribute is a hexadecimal color (ex. #00000), and there isn't a `background-color` attribute set, we want to remove it.
		2. Highlight the text from the semicolon on the previous line until the semicolon on the line with the `color` attribute.
		3. Make sure the "Replace" field is blank.
		4. Click "Replace all".
		5. Click "See what changed" > Ensure each change is expected > If yes, click close; otherwise, click revert changes and go through each change using "Replace & Find" or "Find" (if you don't want the change applied).
		6. Save the file.
		7. Redo step 4.

Optional things:

- Endnotes *not* Footnotes: In the far left pane, with the list of files and folders, scroll to the Miscellaneous > Double-click `toc.xhtml` > Scroll to the bottom > Change the "Footnotes" entry to "Endnotes" (the text just before `</a>`).
	- Apple Pages doesn't have "Endnotes" in the rendered table of contents. To add it:
		1. Double-click "titlePageContent.xhtml"
		2. Scroll to the bottom (should be the last entry of the rendered table of contents).
		3. Copy the last paragraph with a link (`<p><a href="...">...</a></p>`).
		4. Paste the text following the closing paragraph tag (`</p>`) you just copied: You should see two entries for the copied text in your table of contents preview.
		5. Change the link text to "Endnotes" and the `href` value to `footnotes.xhtml`.

## Audiobook

What you'll need:

1. Audio editing software with the ability to:
	- export to the MP3 file format.
	- add [ID3 tags](https://en.wikipedia.org/wiki/ID3).
	- compress audio files.
	- normalize audio files.
	- We'll use [Reaper](https://www.reaper.fm).
2. Microphone.
	- We'll use a [Synco D Series](https://www.syncoaudio.com/collections/d-series-broadcast) shotgun microphone (XLR cable not included).
3. A device for capturing the audio.
	- We'll use a [Zoom H5](https://zoomcorp.com/en/us/handheld-recorders/handheld-recorders/h5/) ([SD card](https://en.wikipedia.org/wiki/SD_card) not included). Note: This device seems to do better with 32-gigabyte cards, and we'll use [Sandisk Ultra](https://www.westerndigital.com/products/memory-cards/sandisk-ultra-uhs-i-sd?sku=SDSDUNC-016G-GN6IN).
4. A way to monitor the audio being recorded. Note: Recommend [over-ear headphones](https://en.wikipedia.org/wiki/Headphones).
	- We'll use the headphones that come with the [Focusrite Scarlett 2i2 Studio](https://us.focusrite.com/products/scarlett-2i2-studio)
	- We'll also use the XLR cable included with the Scarlett 2i2 Studio.
5. A way to make a quick, loud sound to mark mistakes within the recording.
	- We'll use a [clicker trainer](https://en.wikipedia.org/wiki/Clicker_training).

### Recording audio

Note: The cleaner the recording, the easier editing and [mastering](https://en.wikipedia.org/wiki/Mastering_(audio)) will be. My rule is that the audio should be re-recorded if it takes me 3 times longer to edit than the track is long. (This is after practicing and taking at least one track from start to finish.)

- Plug headphones into the device (audio monitor). I recommend turning the volume to 50 on the Zoom H5.
- Be sure the gain dial is turned up for the channel you are recording on (yeah, that was frustrating). You should start hearing sound through the headphones. (I recommend the gain somewhere between 4 and 5; you should be able to barely hear the room noise. When you speak at a normal volume, the bar(s) for the channel you're recording on reach -12 to -6 regularly.)
- Place the microphone just off center from your mouth (this helps avoid [plosives](https://en.wikipedia.org/wiki/Plosive) being recorded). Position yourself so your mouth can be easily positioned 4 inches plus 2 inches. (2 inches for whispering and 6 or more inches if you shout.)
- Each time you hit the record button, a new file will be added to the disk. (I recommend a new file for each major audiobook Part—not every chapter. This helps you warm up, "shoot for coverage," and maintain a flow in the recording session.)
- I recommend:
	- recording from the middle of the book and working to the first and last parts (they will be the last parts recorded). 
	- record a single part and work through the following steps to make adjustments before committing to spending a lot of time recording the entire audiobook.
	- using the clicker to mark mistakes (single) and chapter seaprations (double).

### Editing audio (Reaper; [user guide](https://www.reaper.fm/userguide.php))

https://www.sws-extension.org

Note: Scrolling may seem funky and frustrating. The pointer should be over the track list if you want to move up and down, left and right, or over the timeline if you want to zoom in and out.

1. Plug in headphones and set the computer's volume to halfway.
2. Launch Reaper
	- If this is your first time using Reaper for voiceover recording, recommend setting up Repear to favor voiceover below.
2. File > New project
	- We'll take advantage of subprojects in Reaper.
	- This project will be the primary project.
	- We'll be using Reaper "out of the box."
3. File > Project settings...
	- Title: The title of the Audiobook
	- Author: The name of the Audiobook's author
4. Click OK
5. File > Project Render Metadata...
	- Title: $region (Wildcards > Project Information)
	- Album Artist: $author (Wildcards > Project Information—matches the Author field of the Project settings)
	- Genre: Audiobook
	- Track Number: $filenumber[1] (Wildcards > Project Order—replace the N with a 1; otherwise, the count will start at 0 and not be understood because software engineers are funny that way)
	- Album: $title (Wildcards > Project Information—matches the Title field of the Project settings)
	- Copyright Message: Copyright [owner's name] [year]. [rights]
	- Image File: Select the 300x300 pixel, 96 pixels per inch image file that is the album cover; this should populate the Image Type field.
	- Image Description: Describe the image for the visually impaired. This should describe the image itself. All text in the image should be part of the description. Key elements of the image should also be part of the description.
6. Click OK
7. Split the waveform at the double-click caused by the dog training clicker, denoting a chapter's start. (Note: The waveform still has access to the entire waveform.)
	- Item > Split at...
	- `S` to split where the "Cursor" (yellow vertical line while playing audio) is.
8. Drag the waveform on the right of the split to the right a little to create a gap between those two waveforms. (Note: The waveform should snap into place, leaving the gap.)
9. Select the waveform left of the split > Open the [Context Menu](https://en.wikipedia.org/wiki/Context_menu) (right-click) > Move items to the new subproject.
	- Doing this while the item is selected ensures the subproject places the waveform at the beginning of its timeline.
10. Double-click the waveform to open the subproject in a new tab in the Reaper window.
	- You should see two "Markers" (vertically red lines with a circle at the top) labeled `1` with `=start` to the left and the other labeled `2` with `=end`. This tells the parent project where the start and end of the item should be for the parent project.
	- Make sure the `1` is at the desired beginning of the waveform.
	- Make sure the `2` is at the desired end of the waveform.
	- Ensure Ripple editing is enabled:
		- Options > Ripple edit per track
		- `Option + P`
		- Click the icon that looks like a nine-square grid with a solid center square. (Grayed out is disabled, and green is enabled.)
		- Note: This means when you delete an unwanted section of the waveform, there won't be a gap (the waveform remaining on the right of the removed section will butt up against the waveform on the left).
	- Ensure Snapping is disabled:
		- Options > Snap/grid > Enable snapping (should be unchecked)
		- `Option + S`
		- Click the icon that looks like a horseshoe magnet with the points pointing to the left.
		- Note: When you slide waveform sections around, they won't snap to the grid.
11. Scan the waveform for the spikes made by the dog clicker.
12. Remove the unwanted part of the waveform:
	- Place the green marker to the left of the mistake > S > Place the green marker to the right of the dog clicker spike > Select the waveform between the splits > Delete (the waveform should not have a gap because we enabled ripple editing)
	- Alternatively, you can create a custom action (instructions below)


4. Repeat steps 2 and 3 until each chapter is on its own track.
5. Select a track >  > Move tracks to new subproject
	- Alternatively: Track > Move tracks to new subproject
	- This will create a new Reaper project with the only waveform being the selected track(s), which should make editing easier.


10. Splice the audio to the left where the desired audio starts.
11. Drag the newly created waveform on the left and drag it down to create a new track.
	- Mute this track by clicking the "M" in the track listing.
12. Drag the other waveform to the beginning of the timeline.
10. Play the waveform from the beginning (you shouldn't hear the other track):
	- Pressing the spacebar while paused will start playing where the Time Selection line is. 
	- Pressing the spacebar while it's playing will pause playback (stopping and removing the Cursor).
	- Three things we're trying to accomplish:
		- Discern whether you should re-record this audio.
		- Splice and arrange the waveform to remove mistakes and establish pacing. You don't need to pause playback to splice the waveform.
		- Adjust volume to reduce noticeable breathing, audio gaps, and exceptionally loud parts. I recommend:
			1. [Shift + up](http://user.cockos.com/~glazfolk/ReaperKeyboardShortcuts.pdf) arrow (7 times) should increase the height of the peaks in the waveform, making it easier to see the "loud parts." (Any part of the waveform that collides with the line separating the track from the envelope should be reduced, at least a little; this will help when we add compression and normalize later.)
			2. Shift + single click while the cursor appears to a line with a dot and plus sign (+) to add a control point. (You can drag the control point up and down to increase and decrease the volume at that point.)
11. Repeat steps 9 and 10 until you have the first rough cut of the audio.
12. File > Render... (a dialog should appear; try not to get intimidated)
	1. Source: Master mix
	2. Bounds: Entire project
	3. Output: Pick a directory and file name.
	4. Options (most of the default options should be fine):
		- Sample rate: 44100 (44.1 kilohertz)
		- Channels: Stereo (Joint Stereo)
		- Render speed: Full-speed Offline (for now; we'll shift Online Render for the "Mastered Audio")
		- Primary output format:
			- MP3 (encoder by LAME project): This should ship with Reaper. If you don't see it, [install it](https://forum.cockos.com/showthread.php?t=179167).
			- Mode: Constant bitrate (CBR)
			- Bitrate: 193 kbps
	5. Click Render 1 file
13. Verify audio quality to establish a baseline.
14. Does the file meet the criteria?
	- If it does (most likely won't, and that's okay), note your recording setup and details, and record the rest of the audiobook as close to the same setup as possible. (Then, continue to Bulk render audio.)
	- If it doesn't, add compression and normalization.
15. Repeat steps 1 through 11 until all tracks representing individual chapters have been edited. If you used the same (or similar) setup each time, you should be able to apply the Compression settings you did in step 14.
16. Render master mix

Verify audio quality:

Note: The less technical way to verify audio quality is to contact Scribl support. However, it might take them a day or two to respond. By "technical way," I mean you'll use the command line or Terminal.

See also: [Scribl's documentation](https://scribl.com/guides/how-to-record-an-audiobook/mp3-analysis-sox).

1. macOS only:
	1. [Install MacPorts](https://www.macports.org/install.php)
	2. [Install SoX](https://ports.macports.org/port/sox/) (SoX is short for Sound Exchange)
2. Windows only: [Download and install SoX](https://sourceforge.net/projects/sox/)
3. Open the Terminal app.
4. `cd ~/path/to/file.mp3`
5. `sox file.mp3 -n stats`
	- You should see a grid of labels and numbers. We're interested in 3 numbers:
		1. Pk level dB: The loudest part (less than -2.5dB; between -3.2dB and -3.0dB is ideal)
		2. RMS level dB: The average volume (between -23dB and -18dB; between -20dB and -18dB is ideal)
		3. RMS Tr dB: The quietest part (less than -60dB; the lower, the better)
	- Don't worry if they're not there. We mainly want to see how close they are to meeting the criteria, establishing a baseline to see if changes are making it better or worse.
		
Add compression and normalization:

1. Click the FX on the track; a dialog box should appear.
2. Click the Add button; a dialog box should appear.
3. Under "All Plugins," click "Cockos" (the creators of Reaper) > VST: ReaComp (Cockos)
	- Alternatively, you can type ReaComp into the "Filter" search box.
4. Click VST: ReaComp (Cockos).
5. Click the Add button; the dialog box should disappear, and you should see VST: ReaComp (Cockos) in the left pane of the FX dialog.
6. Ensure there's a checkmark to the left of the name and click to select it; the right pane should display the options for the filter (try not to get overwhelmed).
7. You should see three sliders. The one on the left should say "Threshold." In the text box, change the number to -20. That's it.
8. Ensure the FX icon for the track is highlighted green instead of being grayed out.
	- You may want to render a test file without using Normalize/Limit/Fade
9. File > Render...
10. Keep the same setting you had in Edit audio.
11. Click the Normalize/Limit/Fade button; a dialog box should appear.
12. Check Normalize to > Select Peak from the dropdown > Enter -2.85 in the text box.
	- In my experience, this step has the most influence over the final output.
	- Here's where it gets difficult to describe, and you won't break anything if you start playing with numbers:
		- The greater the normalized number, the greater the numbers for Pk lev dB and RMS lev dB.
		- If you must set the number to less than -4 or greater than -2, you may want to consider re-recording.
		- The lower the Pk lev dB number, the higher your listeners will likely need to increase their volume, so I prioritize getting that number as close as possible to the ideal.
		- There also appears to be a point of diminishing returns when changing any of the numbers. So, yeah, mess around and see what happens.

Render master mix:

1. File > New project
	- I recommend this master project be in the folder containing the folders for the audiobook; this helps with the information architecture of the master mix.
	- The individual chapter projects should be in a folder named "Media" containing the project for the part.
	- Insert multiple tracks > Choose the number of subprojects for the part and the at the end of the project radio button > Click OK
		- This should insert blank tracks at the bottom of the tracklist.
2. Select the first empty track.
4. Select each chapter project > Drag the group of chapter projects until the first empty track is highlighted (a dialog should appear asking how you want to insert the item)
5. Click the Insert project as media item button; 
	- A dialog box should appear asking if you want to adjust the project's tempo to match the current project's.
6. Select Adjust media based on this tempo.
7. Click OK
	- A dialog should appear asking how to position the media item.
8. Select Same time position on separate tracks radio button > Click OK
	- All dialog boxes should now be closed.
	- The newly inserted items should be selected.
	- You may decide to drag each track to the starting point in the timeline, or if you want to listen to the full audio from this project, you may want to stack the chapters.
	- Our concern is mainly that each chapter is a separate track.
9. Rename each track to the following, replacing the number sign (#) with the part number (double-click the black area for the track to the right of the record button): Part # - Track
	- The track number will be added when we render the project.
10. Select the track at the bottom of the tracklist.
11. Repeat steps 4 through 9 until all chapter projects have been added.
12. Click one of the waveforms > Command + A (Select all)
12. File > Render...
13. Source: Selected media items via master; you should have the total number of items equal to the number of waveforms in the project.
14. Output:
	- Directory: Click Browse... > Select Browse for directory (a dialog should appear) > Select or create "Master" directory where the project is saved > Click Open
	- Filename: Recommend [kebab-cased](https://en.wikipedia.org/wiki/Letter_case#Kebab_case) title of the book, followed by "master," followed the wildcard of the filename: ex. time-master-$filenumber[1]
		- Re the file number: Add an extra hyphen (-) after "master" > Click Wildcards button > Project order > $filenumber[N]
		- Once added to the filename, replace the capital N with the number 1; this ensures the first file number will be 1 instead of 0—this becomes important later.
15. Sample rate: 44100 (44.1 kilohertz)
16. Channels: Stereo
17. Rendering options: 
	- 1x Offline (this means it won't play as it's rendering, but it also won't try to rush things)
	- Check 2nd pass render
18. Replicate the Normalize settings you used for the quality test track. (Note: Adding the compressor FX in the chapter projects is easier.)


### Setting up Reaper for voiceover

The primary source for this setup is Mike Delgaudio's Booth Junkie videos:

1. [Reaper presets - Part 1](https://www.youtube.com/watch?v=yiZhqbSAyzA)
2. [Reaper presets - Part 2](https://www.youtube.com/watch?v=ooSmb4oboyQ)

While these are optional for your setup, I've emphasized which ones I use only in certain situations.

1. Launch Reaper
2. [Control-click](https://support.apple.com/guide/mac-help/right-click-mh35853/mac) (right-click) the timeline at the top of the window (the context menu should appear) > Minutes:Seconds (alternatively, use the View menu)
3. [Disable snapping](https://wiki.cockos.com/wiki/index.php/Snap_and_Grid_Settings) (`Option + S`)
	- Optional: I usually do this when actually editing and sliding waveforms to specific points on the timeline)
4. [Disable the grid](https://wiki.cockos.com/wiki/index.php/Snap_and_Grid_Settings) (`Option + G`)
	- Optional: I usually do this when actually editing and sliding waveforms to specific points on the timeline)
5. Control-click (right-click) the time signature (just below the timeline, has "BPM" in there somewhere):
	- Select show time signature (uncheck)
	- Select show playrate control (uncheck)
6. Control-click (right-click) a blank area in the toolbar (upper left corner of the window) > Hover over switch toolbar > Toolbars 1-32 > Select toolbar 1
	1. Click the edit me button (should be the only button in the toolbar); it should bring up the toolbar editor, which you can also get to by control-clicking the toolbar and choosing "customize toolbar"
	2. Click "Retitle..." > Type "Voiceover toolbar" > Click OK (should dismiss the dialog)
	3. Select "Edit me" in the left pane of the "Customize menus/toolbars window > Click "Remove" or hit the delete key
	4. Click Add... (should bring up the "Actions" chooser)
	5. In the "Filter" field type: ripple
	6. Select "Options: Cycle ripple editing mode"
	7. Click "Select/Close" ("Select" adds it to the toolbar, "Close" close the "Actions" chooser)
	8. Click Add... > Apply filter: render > Double-click File: Render project, using the most recent settings (should perform "Select/Close") > Click Render project button (if you want an icon for it) > Icon... (near Add...) > Change icon... > Choose an icon (I use Filter: render > Render to mono) > Close the icon picker
	9. Click OK
7. If you decide to change your screen layout, you can save them using by: View > Screensets layouts (`Command + E`) > Select the first slot > Save
	- Get it near the way you'd like it, if nothing else (you can always update and save it later)
8. File > Project templates > Save project as template > Name it something (I use Voiceover template) > Click Save
9. Reaper > Settings > Project > Browse button > Select your template > Click Open (now when you create a new project or subproject )
10. Reaper > Settings > Project > Enable prompt to save on new project (this will automatically ask you to save the project somewhere when you create a new project if one is not already created for you)

### Create editing action

Again, Mike Delgaudio comes to the rescue with [this video](https://youtu.be/yn_chAP8814).

1. Custom name of Delete from Time Selection
2. Actions > Show action list > New custom action
2. Filter "ripple" > Drag Set ripple editing per-track to the right pane
3. Filter "split" > Drag Item: Split items at time selection to the right pane (might be optional)
4. Filter "remove" > Drag Time selection: Remove contents of time select (moving later items) to right pane
5. Filter "end" > Drag Go to end of time selection to right pane
6. Click OK
7. Select Custom: Delete from Time Selection
8. Click Add.. (this should bring up the key binding panel)
9. Tap the key (or keys) you wish to make the shortcut (I use `Command + Y`)