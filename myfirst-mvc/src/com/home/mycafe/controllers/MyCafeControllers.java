package com.home.mycafe.controllers;

import javax.servlet.http.HttpServletRequest;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
public class MyCafeControllers {

	@RequestMapping("/cafe")
	public String showWelcomePage(Model model)
	{
		
		//sending data to view(jsp page)
		String myName="Sagarika1";  //this data to view page is done by view
		
		
		model.addAttribute("myNameValue",myName);
		model.addAttribute("myWebsitetitle","MOM'S CAFE");
		
		
		return "welcome-page";
	}
	
	@RequestMapping("/processOrder")
	public String processOrder(HttpServletRequest request,Model model)
	{
		String userValue=request.getParameter("foodType");
		model.addAttribute("userInput",userValue);
		//handle data received from the user
		
		//set the user data with the model object and send it to view
		return "process-order";
	}
}
