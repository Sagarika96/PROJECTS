package com.home.controllers;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;

@Controller
public class BroController {

	
	//@ResponseBody not fit for good coding only for http response body
	@RequestMapping("/cricket")
	public String giveCricketBat()
	{
		return "MRFCricketBat";
		//keeping view folder under web-inf is not good for real time
	//so we should use view resolver for this it has prefix and suffix
	//view resolver is in the class internal view resolver
		//enough to give the file name alone file path or extension name does not matter
	}
	
	
}
