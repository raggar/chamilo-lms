<?php
/* For licensing terms, see /license.txt */

use Chamilo\CoreBundle\Framework\Container;

/**
 *  @package chamilo.admin
 */
$cidReset = true;
$this_section = SECTION_PLATFORM_ADMIN;
api_protect_admin_script();

if (api_get_setting('skill.allow_skills_tool') != 'true') {
    api_not_allowed();
}

//Adds the JS needed to use the jqgrid
$htmlHeadXtra[] = api_get_js('componentes/jsplumb/dist/js/jsPlumb-2.0.4.js');
$htmlHeadXtra[] = api_get_js('componentes/jquery.ui.touch/jquery.ui.touch.js');
$htmlHeadXtra[] = api_get_js('js/skills.js');

$skill  = new Skill();
$type   = 'edit'; //edit
$tree   = $skill->get_skills_tree(null, null, true);
$skill_visualizer = new SkillVisualizer($tree, $type);

$html = $skill_visualizer->return_html();
$url  = api_get_path(WEB_AJAX_PATH).'skill.ajax.php?1=1';

$tpl = new Template(null, false, false);

$tpl->assign('url', $url);
$tpl->assign('html', $html);
$tpl->assign('skill_visualizer', $skill_visualizer);
$tpl->assign('js', $skill_visualizer->return_js());

//
$content = $tpl->fetch('default/skill/skill_tree.tpl');
$tpl->assign('content', $content);
$tpl->display_no_layout_template();
