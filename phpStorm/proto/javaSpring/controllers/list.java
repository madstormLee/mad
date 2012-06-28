<?
$packages = $classDiagram->packages;
$interface = $packages->models->classes->interface->name;
$instance = lcFirst( $interface );
$model = $packages->models->classes->model->name;
$modelPackage = $packages->models->name;
?>
/**
 * Class Name  : <?=$class->name?>00L.java
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
import com.a2m.framework.util.PageNavigator;

import <?=$modelPackage?>.<?=$interface?>;

@Controller
public class <?=$class->name?>00L implements SimpleController {
	@Resource(name="<?=$model?>")
	private <?=$interface?> <?=$instance?>;

	@SuppressWarnings("unchecked")
	@RequestMapping("mng/conts/<?=$project.$interface?>/<?=$instance?>00_l.do")
	
	public ModelAndView doInit(HttpServletRequest request, HttpServletResponse response, Map Reference)
	throws Exception {

		Map params = ReqUtils.getParameterMap(request);

		ModelAndView mav = new ModelAndView("mng/conts/<?=$project.$interface?>/<?=$instance?>00_l");

		String gubun 			= ReqUtils.getEmptyResult2((String)params.get("gubun"), "");
		String word 			= ReqUtils.getEmptyResult2((String)params.get("word"), "");			

		String cPage 			= ReqUtils.getEmptyResult2((String)params.get("cPage"), "1");
		String listCnt 			= ReqUtils.getEmptyResult2((String)params.get("listCnt"), "10");

		int intPage = Integer.parseInt(cPage);			/* 현재페이지 */
		int intListCnt = Integer.parseInt(listCnt);		/* 세로페이징(게시글수)*/
		int pageCnt = 10;								/* 가로페이징(페이지수) */
		int totalCnt = 0;								/* 총 건수  */

		totalCnt = <?=$instance?>.getListCnt(params);
		// 페이지 네비게이터 생성
		PageNavigator pageNavigator = new PageNavigator(
				intPage		
				,"<?=$instance?>00_l.do"
				,pageCnt		
				,intListCnt	
				,totalCnt	
				,""
				);


		// 시작 인덱스
		int startIndex = pageNavigator.getRecordPerPage() * (intPage - 1);
		List list = <?=$instance?>.getList(params, startIndex, pageNavigator.getRecordPerPage());

		Map listparam = new HashMap();

		listparam.put("cPage", intPage);
		listparam.put("intListCnt", intListCnt);
		listparam.put("pageCnt", pageCnt);
		listparam.put("totalCnt", totalCnt);

		Map referenceMap = new HashMap();
		referenceMap.put("getList", list);
		referenceMap.put("listparam", listparam);
		referenceMap.put("pageNavigator", pageNavigator.getMakePage());	/* 페이징 */

		mav.addAllObjects(referenceMap);

		System.out.println("tested");
		return mav;	
	}

	public ModelAndView doRequest(HttpServletRequest request, HttpServletResponse response, Map reference) throws Exception {
		return null;
	}

	public ModelAndView doSubmit(HttpServletRequest request, HttpServletResponse response, String mode) throws Exception {
		return null;
	}

	@SuppressWarnings("unchecked")
	@ModelAttribute("referenceMap")
	public Map getReference(HttpServletRequest request) throws Exception{		
		return null;
	}
}
