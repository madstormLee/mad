<?
$packages = $classDiagram->packages;
$interface = $packages->models->classes->interface->name;
$iBatis = $interface;
?>
/**
 * Class Name  : <?=$class->name?>.java
 * Description : <?=$class->description?> 
 * @version 1.0
 */

package <?=$package->name?>;

import java.sql.SQLException;
import java.util.List;
import java.util.Map;

import javax.annotation.Resource;
import org.springframework.stereotype.Component;

import com.a2m.framework.dao.AbstractDao;
import com.ibatis.sqlmap.client.SqlMapClient;

@Component("<?=$class->name?>")
public class <?=$class->name?> extends AbstractDao implements <?=$interface?> {
	
	@Resource(name="sqlMapClientBase") 
	protected void setSqlMap(SqlMapClient sqlMapClient){
		setSqlMapClient(sqlMapClient);
	}
	
	public List getList(Map args, int startIndex, int recordPerPage) throws SQLException {
		return getPageList("<?=$iBatis?>.getList", args, startIndex, recordPerPage);
	}

	public int getListCnt(Map args) throws SQLException {
		return getCount("<?=$iBatis?>.getListCnt", args);
	}	
	
	public Map getMap(Map args) throws SQLException {
		return getMap("<?=$iBatis?>.getMap", args);
	}

	public void insert(Map args) throws SQLException {
		insert("<?=$iBatis?>.insert", args);
	}

	public void update(Map args) throws SQLException {
		modify("<?=$iBatis?>.update", args);
	}

	public void delete(Map args) throws SQLException {
		remove("<?=$iBatis?>.delete", args);
	}
	
	public void updateCount(Map args) throws SQLException {
		modify("<?=$iBatis?>.updateCount", args);
	}
	
}
