<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Test helpers for the crossword question type.
 *
 * @package qtype_crossword
 * @copyright 2022 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');

/**
 * Test helper class for the crossword question type.
 *
 * @package qtype_crossword
 * @copyright 2022 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_crossword_test_helper extends question_test_helper {

    /**
     * Get test question function.
     *
     * @return array The test question array.
     */
    public function get_test_questions(): array {
        return ['normal', 'unicode', 'different_codepoint', 'sampleimage'];
    }

    /**
     * Makes a normal crossword question.
     *
     * The crossword layout is:
     *
     *     P
     * B R A Z I L
     *     R
     *     I T A L Y
     *     S
     *
     * @return qtype_crossword_question
     */
    public function make_crossword_question_normal() {
        question_bank::load_question_definition_classes('crossword');
        $cw = new qtype_crossword_question();
        test_question_maker::initialise_a_question($cw);
        $cw->name = 'Cross word question';
        $cw->questiontext = 'Cross word question text.';
        $cw->correctfeedback = 'Cross word feedback.';
        $cw->correctfeedbackformat = FORMAT_HTML;
        $cw->penalty = 1;
        $cw->defaultmark = 1;
        $cw->numrows = 5;
        $cw->numcolumns = 7;
        $cw->qtype = question_bank::get_qtype('crossword');
        $answerslist = [
            (object) [
                'id' => 1,
                'questionid' => 1,
                'clue' => 'where is the Christ the Redeemer statue located in?',
                'answer' => 'BRAZIL',
                'startcolumn' => 0,
                'startrow' => 1,
                'orientation' => 0,
            ],
            (object) [
                'id' => 2,
                'questionid' => 1,
                'clue' => 'Eiffel Tower is located in?',
                'answer' => 'PARIS',
                'startcolumn' => 2,
                'startrow' => 0,
                'orientation' => 1,
            ],
            (object) [
                'id' => 3,
                'questionid' => 1,
                'clue' => 'Where is the Leaning Tower of Pisa?',
                'answer' => 'ITALY',
                'startcolumn' => 2,
                'startrow' => 3,
                'orientation' => 0,
            ],
        ];

        foreach ($answerslist as $answer) {
            $cw->answers[] = new \qtype_crossword\answer(
                $answer->answer,
                $answer->clue,
                $answer->orientation,
                $answer->startrow,
                $answer->startcolumn,
            );
        }
        return $cw;
    }

    /**
     * Makes a normal crossword question.
     */
    public function get_crossword_question_form_data_normal() {
        $fromform = new stdClass();
        $fromform->name = 'Cross word question';
        $fromform->questiontext = ['text' => 'Crossword question text', 'format' => FORMAT_HTML];
        $fromform->correctfeedback = ['text' => 'Correct feedback', 'format' => FORMAT_HTML];
        $fromform->partiallycorrectfeedback = ['text' => 'Partially correct feedback.', 'format' => FORMAT_HTML];
        $fromform->incorrectfeedback = ['text' => 'Incorrect feedback.', 'format' => FORMAT_HTML];
        $fromform->penalty = 1;
        $fromform->defaultmark = 1;
        $fromform->answer = ['BRAZIL', 'PARIS', 'ITALY'];
        $fromform->clue = [
            'where is the Christ the Redeemer statue located in?',
            'Eiffel Tower is located in?',
            'Where is the Leaning Tower of Pisa?'
        ];
        $fromform->orientation = [0, 1, 0];
        $fromform->startrow = [1, 0, 3];
        $fromform->startcolumn = [0, 2, 2];
        $fromform->numrows = 5;
        $fromform->numcolumns = 7;
        return $fromform;
    }

    /**
     * Makes a normal crossword question with a sample image in question text.
     *
     * @return qtype_crossword_question
     */
    public function get_crossword_question_form_data_sampleimage() {
        $fromform = $this->get_crossword_question_form_data_normal();
        $fromform->questiontext = ['text' => 'Cross word question text with sample image <img src="@@PLUGINFILE@@/test.jpg" />',
            'format' => FORMAT_HTML];
        return $fromform;
    }

    /**
     * Makes a unicode crossword question.
     *
     * @return qtype_crossword_question
     */
    public function make_crossword_question_unicode() {
        question_bank::load_question_definition_classes('crossword');
        $cw = new qtype_crossword_question();
        test_question_maker::initialise_a_question($cw);
        $cw->name = 'Cross word question unicode';
        $cw->questiontext = 'Cross word question text unicode.';
        $cw->correctfeedback = 'Cross word feedback unicode.';
        $cw->correctfeedbackformat = FORMAT_HTML;
        $cw->penalty = 1;
        $cw->defaultmark = 1;
        $cw->numrows = 4;
        $cw->numcolumns = 4;
        $cw->qtype = question_bank::get_qtype('crossword');
        $answerslist = [
            (object) [
                'id' => 1,
                'questionid' => 2,
                'clue' => '线索 1',
                'answer' => '回答一',
                'startcolumn' => 0,
                'startrow' => 2,
                'orientation' => 1,
            ],
            (object) [
                'id' => 2,
                'questionid' => 2,
                'clue' => '线索 2',
                'answer' => '回答两个',
                'startcolumn' => 0,
                'startrow' => 2,
                'orientation' => 0,
            ],
            (object) [
                'id' => 3,
                'questionid' => 2,
                'clue' => '线索 3',
                'answer' => '回答三',
                'startcolumn' => 1,
                'startrow' => 1,
                'orientation' => 1,
            ],
        ];

        foreach ($answerslist as $answer) {
            $cw->answers[] = new \qtype_crossword\answer(
                $answer->answer,
                $answer->clue,
                $answer->orientation,
                $answer->startrow,
                $answer->startcolumn,
            );
        }
        return $cw;
    }

    /**
     * Get a unicode crossword question form data.
     */
    public function get_crossword_question_form_data_unicode() {
        $fromform = new stdClass();
        $fromform->name = 'Cross word question unicode';
        $fromform->questiontext = ['text' => 'Crossword question text unicode', 'format' => FORMAT_HTML];
        $fromform->correctfeedback = ['text' => 'Correct feedback', 'format' => FORMAT_HTML];
        $fromform->partiallycorrectfeedback = ['text' => 'Partially correct feedback.', 'format' => FORMAT_HTML];
        $fromform->incorrectfeedback = ['text' => 'Incorrect feedback.', 'format' => FORMAT_HTML];
        $fromform->penalty = 1;
        $fromform->defaultmark = 1;
        $fromform->answer = ['回答一', '回答两个', '回答三'];
        $fromform->clue = [
            '线索 1',
            '线索 2',
            '线索 3'
        ];
        $fromform->orientation = [1, 0, 1];
        $fromform->startrow = [2, 2, 1];
        $fromform->startcolumn = [0, 0, 1];
        $fromform->numrows = 4;
        $fromform->numcolumns = 4;
        return $fromform;
    }

    /**
     * Makes a crossword question has two same answers but different code point.
     *
     * @return qtype_crossword_question
     */
    public function make_crossword_question_different_codepoint() {
        question_bank::load_question_definition_classes('crossword');
        $cw = new qtype_crossword_question();
        test_question_maker::initialise_a_question($cw);
        $cw->name = 'Cross word question different codepoint';
        $cw->questiontext = 'Cross word question text different codepoint.';
        $cw->correctfeedback = 'Cross word feedback different codepoint.';
        $cw->correctfeedbackformat = FORMAT_HTML;
        $cw->penalty = 1;
        $cw->defaultmark = 1;
        $cw->numrows = 6;
        $cw->numcolumns = 6;
        $cw->qtype = question_bank::get_qtype('crossword');
        $answerslist = [
            (object) [
                'id' => 1,
                'questionid' => 2,
                'clue' => 'Answer contains letter é has codepoint \u00e9',
                'answer' => 'Amélie',
                'startcolumn' => 0,
                'startrow' => 3,
                'orientation' => 0,
            ],
            (object) [
                'id' => 2,
                'questionid' => 2,
                'clue' => 'Answer contains letter é has codepoint \u0065\u0301',
                'answer' => 'Amélie',
                'startcolumn' => 2,
                'startrow' => 1,
                'orientation' => 1,
            ],
        ];

        foreach ($answerslist as $answer) {
            $cw->answers[] = new \qtype_crossword\answer(
                $answer->answer,
                $answer->clue,
                $answer->orientation,
                $answer->startrow,
                $answer->startcolumn,
            );
        }
        return $cw;
    }

    /**
     * Get a different codepoint crossword question form data.
     */
    public function get_crossword_question_form_data_different_codepoint() {
        $fromform = new stdClass();
        $fromform->name = 'Cross word question different codepoint';
        $fromform->questiontext = ['text' => 'Crossword question text different codepoint', 'format' => FORMAT_HTML];
        $fromform->correctfeedback = ['text' => 'Correct feedback', 'format' => FORMAT_HTML];
        $fromform->partiallycorrectfeedback = ['text' => 'Partially correct feedback.', 'format' => FORMAT_HTML];
        $fromform->incorrectfeedback = ['text' => 'Incorrect feedback.', 'format' => FORMAT_HTML];
        $fromform->penalty = 1;
        $fromform->defaultmark = 1;
        $fromform->answer = ['Amélie', 'Amélie'];
        $fromform->clue = [
            'Answer contains letter é has codepoint \u00e9',
            'Answer contains letter é has codepoint \u0065\u0301',
        ];
        $fromform->orientation = [0, 1];
        $fromform->startrow = [3, 1];
        $fromform->startcolumn = [0, 2];
        $fromform->numrows = 6;
        $fromform->numcolumns = 6;
        return $fromform;
    }

    /**
     * Retrieve the context object.
     * @param \context $context the current context.
     *
     * @return object The context object.
     */
    public static function question_edit_contexts(\context $context): object {
        if (class_exists('\core_question\local\bank\question_edit_contexts')) {
            $contexts = new \core_question\local\bank\question_edit_contexts($context);
        } else {
            $contexts = new \question_edit_contexts($context);
        }
        return $contexts;
    }
}
