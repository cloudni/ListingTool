package test;

import java.util.List;

import org.junit.Test;
import org.springframework.beans.factory.annotation.Autowired;

import com.lt.dao.model.ResourceString;
import com.lt.frontend.home.service.IResourceStringService;
import com.lt.platform.framework.exception.RDPException;


public class TestResource extends BaseJunitTest
{
	@Autowired
	private IResourceStringService resourceStringService;
	
	@Test
	public void  getAllResource() throws RDPException{
		List<ResourceString> aa = resourceStringService.selectByLanguage((short)2);
		System.err.println(aa.size());
	}
}
