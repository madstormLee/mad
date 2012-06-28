/**
 * Class Name  : <?=$class->name?>.java
 * Description : <?=$class->description?> 
 * @version 1.0
 */

package <?=$package->name?>;

import java.sql.SQLException;
import java.util.List;
import java.util.Map;

public interface <?=$class->name?> {
	List getList(Map args, int startIndex, int recordPerPage) throws SQLException;
	
	int getListCnt(Map args) throws SQLException;
	
	Map getMap(Map args) throws SQLException;
	
	void insert(Map args) throws SQLException;
	
	void update(Map args) throws SQLException;
	
	void delete(Map args) throws SQLException;
	
	void updateCount(Map args) throws SQLException;
}
