package com.a2m.framework.dao;

import java.sql.SQLException;
import java.util.List;
import java.util.Map;

import org.springframework.orm.ibatis.support.SqlMapClientDaoSupport;

public class AbstractDao extends SqlMapClientDaoSupport implements Dao{
	
	public List getList(String qry, Map args) throws SQLException {
		return getSqlMapClientTemplate().queryForList(qry, args);
	}
	
	public List getPageList(String qry, Map args, int startIndex, int recordPerPage) throws SQLException {
		return getSqlMapClientTemplate().queryForList(qry, args, startIndex, recordPerPage);
	}

	public int getCount(String qry, Map args) throws SQLException {
		return (Integer)getSqlMapClientTemplate().queryForObject(qry, args);
	}	
	
	public Map getMap(String qry, Map args) throws SQLException {
		return (Map)getSqlMapClientTemplate().queryForObject(qry, args);
	}

	public Object getValue(String qry, Map args) throws SQLException {
		return getSqlMapClientTemplate().queryForObject(qry, args);
	}

	public Object insert(String qry, Map args) throws SQLException {
		return getSqlMapClientTemplate().insert(qry, args);
	}

	public Object modify(String qry, Map args) throws SQLException {
		return getSqlMapClientTemplate().update(qry, args);
	}

	public Object remove(String qry, Map args) throws SQLException {
		return getSqlMapClientTemplate().delete(qry, args);
	}
	
	/**
	 * 트랜잭션의 이용 - com/a2m/module/업무/../model/*Service.java 에 적용
	 * 
	 * 1) 트랜잭션 어노테이션용 클래스 Import
	 * import org.springframework.transaction.annotation.Propagation;
	 * import org.springframework.transaction.annotation.Transactional;
	 * 
	 * 2) 트랜잭션을 사용할 메소드에 어노테이션 적용
	 * @Transactional(propagation=Propagation.REQUIRED)
	 */

}
