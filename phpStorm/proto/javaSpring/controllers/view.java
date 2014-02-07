<?
$packages = $classDiagram->packages;
$interface = $packages->models->classes->interface->name;
$instance = $interface->lcFirst();
$model = $packages->models->classes->model->name;
$modelPackage = $packages->models->name;
?>
/**
 * Class Name  : <?=$class->name?>00V.java
 * Description : <?=$class->description?> 
 * @version 1.0
 */

package <?=$package->name?>;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import com.a2m.framework.controller.SimpleController;
import com.a2m.framework.util.ReqUtils;

import <?=$modelPackage?>.<?=$interface?>;


@Controller
public class <?=$class->name?>00V implements SimpleController {

	@Resource(name="<?=$model?>")
	private <?=$interface?> <?=$instance?>;

	@SuppressWarnings("unchecked")
    @RequestMapping("mng/conts/<?=$project.$interface?>/<?=$instance?>00_v.do")
	public ModelAndView doInit(HttpServletRequest request, HttpServletResponse response, Map Reference) throws Exception {
		Map params = ReqUtils.getParameterMap(request);
		
		ModelAndView mav = new ModelAndView("mng/conts/<?=$project.$interface?>/<?=$instance?>00_v");
			
		Map getValue = <?=$instance?>.getMap(params);
		mav.addObject("getValue",ReqUtils.getResultNullChk(getValue));
		
		return mav;			
	}

	public ModelAndView doRequest(HttpServletRequest request, HttpServletResponse response, Map reference) throws Exception {
		return null;
	}

	public ModelAndView doSubmit(HttpServletRequest request, 
			HttpServletResponse response, String mode) throws Exception {
		return null;
	}

	@SuppressWarnings("unchecked")
	@ModelAttribute("referenceMap")
	public Map getReference(HttpServletRequest request) throws Exception{		
		return null;
	}

}
