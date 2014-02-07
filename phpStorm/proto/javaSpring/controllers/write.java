<?
$packages = $classDiagram->packages;
$interface = $packages->models->classes->interface->name;
$instance = $interface->lcFirst();
$model = $packages->models->classes->model->name;
$modelPackage = $packages->models->name;
?>
/**
 * Class Name  : <?=$class->name?>00U.java
 * Description : <?=$class->description?> 
 * @version 1.0
 */

package <?=$package->name?>;

import java.io.File;
import java.util.Calendar;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.multipart.MultipartHttpServletRequest;
import org.springframework.web.servlet.ModelAndView;

import com.a2m.framework.consts.VarConsts;
import com.a2m.framework.controller.SimpleController;
import com.a2m.framework.util.ReqUtils;
import com.a2m.framework.util.PageNavigator;

import <?=$modelPackage?>.<?=$interface?>;

@Controller
public class <?=$class->name?>00U implements SimpleController {
	@Resource(name="<?=$model?>")
	private <?=$interface?> <?=$instance?>;
	
	@SuppressWarnings("unchecked")
	@RequestMapping("mng/conts/<?=$project.$interface?>/<?=$instance?>00_u.do")
	public ModelAndView doInit(HttpServletRequest request, HttpServletResponse response, @ModelAttribute("referenceMap") Map reference) throws Exception {
		Map params = ReqUtils.getParameterMap(request);
		
		ModelAndView mav = new ModelAndView("mng/conts/<?=$project.$interface?>/<?=$instance?>00_u");
		
		if(params.get("artl_id")==null||("null".equals((String)params.get("artl_id")))){ //등록 화면		
			Map getValue = null;
			mav.addObject("getValue", getValue);		
		}else if(params.get("artl_id")!=null|| !("null".equals((String)params.get("artl_id")))){ //수정 화면
			Map getValue = <?=$instance?>.getMap(params);					
			mav.addObject("getValue",ReqUtils.getResultNullChk(getValue));			
		}

		mav.addAllObjects(reference);
		
		return mav;			
	}


	public ModelAndView doRequest(HttpServletRequest request, HttpServletResponse response, Map reference) throws Exception {
		return null;
	}

	@SuppressWarnings("unchecked")
	@RequestMapping("mng/conts/<?=$project.$interface?>/<?=$instance?>00_t.do")
	public ModelAndView doSubmit(HttpServletRequest request, 
			HttpServletResponse response,
			@RequestParam(required=true,value="mode") String mode)
	throws Exception {	

		Map params = ReqUtils.getParameterMap(request);

		ModelAndView mav = new ModelAndView();        

		String new_file = (String)params.get("fileTxt"); // 파일 생성 여부

		MultipartFile file = null;	
		String file_cont = "";
		if(!mode.equals(VarConsts.MODE_D)){
			MultipartHttpServletRequest multiRequest = (MultipartHttpServletRequest) request;

			String FileName = "", FileRealName = "", ext="";
			int ext_cnt = 0;
			int cnt = 0;
			long FileSize; 
			for(Iterator it = multiRequest.getFileNames();it.hasNext();){			
				file = multiRequest.getFile((String)it.next());
				if(file.getSize() > 0){//file.getOriginalFilename() != null	
					System.out.println("file.getSize() : "+file.getSize());
					File Del = new File(request.getSession().getServletContext().getRealPath(VarConsts.FILE_PATH+"/"+(String)params.get("real")));
					if ( Del.isFile() ) {
						Del.delete();
					} // 서버파일삭제
					ReqUtils.upFolder(request, VarConsts.FILE_PATH);
					FileName = file.getOriginalFilename();
					ext_cnt = FileName.lastIndexOf(".");
					ext = FileName.substring(ext_cnt + 1);
					FileRealName = ""+Calendar.getInstance().getTimeInMillis()+cnt+"."+ext;
					FileSize = file.getSize();						
					file.transferTo( new File( new File( request.getSession().getServletContext().getRealPath(VarConsts.FILE_PATH)), FileRealName ) );
					cnt++;

					file_cont = FileName+"*"+FileRealName;

				}
			}
		}

		/* 기존에 있던 첨부파일 등록 */
		Object exist = params.get("exist_file");
		if (exist instanceof String){	
			file_cont = (String)params.get("exist_file");
		}else if (exist instanceof String[]){
			String[] arr = (String[])params.get("exist_file");
			for(int k=0; k<arr.length; k++){
				file_cont = file_cont;
			}
		}

		System.out.println("file_cont : "+file_cont);
		if(!"".equals(file_cont)){
			params.put("att_file", file_cont);
		}

		if(file == null){
			if("Y".equals((String)params.get("delChk"))){
				File Del = new File(request.getSession().getServletContext().getRealPath(VarConsts.FILE_PATH+"/"+(String)params.get("realfile")));
				if ( Del.isFile() ) {
					Del.delete();
				} /* 서버파일 삭제 */
				params.put("att_file", "");
			}					
		}

		if(mode.equals(VarConsts.MODE_I)){
			<?=$instance?>.insert(params);
		}else if(mode.equals(VarConsts.MODE_U)){
			<?=$instance?>.update(params);
		}else if(mode.equals(VarConsts.MODE_D)){				
			// 파일 삭제
			<?=$instance?>.delete(params);				
		}

		mav.setViewName("redirect:/mng/conts/<?=$project.$interface?>/<?=$interface?>00_l.do");		
		return mav;		
	}	

	@SuppressWarnings("unchecked")
		@ModelAttribute("referenceMap")
		public Map getReference(HttpServletRequest request) throws Exception{	
			Map params = new HashMap(); 		
			return params;
		}
}
