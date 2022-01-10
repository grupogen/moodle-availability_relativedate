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
 * Unit tests for frontend of relativedate condition.
 *
 * @package availability_relativedate
 * @copyright 2019 Renaat Debleu <info@eWallah.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace availability_relativedate;

/**
 * Unit tests for frontend of relativedate condition.
 *
 * @package availability_relativedate
 * @copyright 2019 Renaat Debleu <info@eWallah.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @coversDefaultClass \availability_relativedate\frontend
 */
class frontend_test extends \advanced_testcase {

    /**
     * Tests using relativedate condition in front end.
     */
    public function test_frontend() {
        global $DB;
        $this->resetAfterTest();
        $this->setAdminUser();
        set_config('enableavailability', true);
        $enabled = enrol_get_plugins(true);
        $enabled['self'] = true;
        set_config('enrol_plugins_enabled', implode(',', array_keys($enabled)));
        $dg = $this->getDataGenerator();
        $course = $dg->create_course();
        $modinfo = get_fast_modinfo($course);
        $sections = $modinfo->get_section_info_all();
        $selfplugin = enrol_get_plugin('self');
        $instance = $DB->get_record('enrol', ['courseid' => $course->id, 'enrol' => 'self'], '*', MUST_EXIST);
        $DB->set_field('enrol', 'enrolenddate', time() + 10000, ['id' => $instance->id]);
        $instance = $DB->get_record('enrol', ['courseid' => $course->id, 'enrol' => 'self'], '*', MUST_EXIST);
        $user = $dg->create_user();
        $selfplugin->enrol_user($instance, $user->id);
        $name = '\availability_relativedate\frontend';
        $frontend = new frontend();
        $this->assertCount(4, \phpunit_util::call_internal_method($frontend, 'get_javascript_init_params', [$course], $name));
        $this->assertTrue(\phpunit_util::call_internal_method($frontend, 'allow_add', [$course, null, $sections[0]], $name));
        $this->assertTrue(\phpunit_util::call_internal_method($frontend, 'allow_add', [$course, null, $sections[1]], $name));
        $this->assertTrue(\phpunit_util::call_internal_method($frontend, 'allow_add', [$course], $name));
    }

    /**
     * Test behat funcs
     * @coversDefaultClass behat_availability_relativedate
     */
    public function test_behat() {
        global $CFG;
        require_once($CFG->dirroot . '/availability/condition/relativedate/tests/behat/behat_availability_relativedate.php');
        $this->resetAfterTest();
        $this->setAdminUser();
        set_config('enableavailability', true);
        $course = $this->getDataGenerator()->create_course(['enablecompletion' => true]);
        $class = new \behat_availability_relativedate();
        $class->selfenrolment_exists_in_course_starting($course->fullname, '');
        $class->selfenrolment_exists_in_course_starting($course->fullname, '##-10 days noon##');
        $class->selfenrolment_exists_in_course_ending($course->fullname, '');
        $class->selfenrolment_exists_in_course_ending($course->fullname, '## today ##');
        $this->expectExceptionMessage('behat_context_helper');
        $class->i_should_see_relativedate('##-10 days noon##');
    }
}
