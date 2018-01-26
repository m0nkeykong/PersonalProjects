package RH.PE;

import java.util.Arrays;
import java.util.List;

import javax.swing.BorderFactory;
import javax.swing.ImageIcon;
import javax.swing.JLabel;
import javax.swing.JTable;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.DefaultTableModel;
import javax.swing.table.JTableHeader;
import javax.swing.table.TableModel;
import javax.swing.table.TableRowSorter;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;

import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.SAXException;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.io.*;
import java.net.*;

public class Model
{

	public enum Rate
	{
		USD, GBP, JPY, EUR, AUD, CAD, DKK, NOK, ZAR, SEK, CHF, JOD, LBP, EGP;
		
		
		private String name;
		private int unit;
		private String currCode;
		private String country;
		private double rate;
		private double change;
		

		// setters
		public void setUnit(int unit) {this.unit = unit;}
		public void setcurrCode(String currCode) {this.currCode = currCode;}
		public void setRate(double rate) {this.rate = rate;}
		public void setChange(double change) {this.change = change;}
		public void setName(String name) {this.name = name;}
		public void setCountry(String country) {this.country = country;}
		
		// getters
		public int getUnit() {return this.unit;}
		public String getcurrCode() {return this.currCode;}
		public double getRate() {return this.rate;}
		public double getChange() {return this.change;}
		public String getName() {return this.name;}
		public String getCountry() {return this.country;}	
		}

		
		private Rate rates[];
		private InputStream url;
		private String upToDate;
		
		private JTable table;
		private TableRowSorter<TableModel> rowSorter;
		FileOutputStream fos = null;
		DataOutputStream whereTo = null;
		
		
	@SuppressWarnings("deprecation")
	Model()
	{
		try
		{
			fos = new FileOutputStream("currencyRates.txt");
			whereTo = new DataOutputStream(fos);
		} 
		catch (FileNotFoundException e2)
		{
			// TODO Auto-generated catch block
			e2.printStackTrace();
		}
		
		rates = Rate.values();
		
		//parsing the XML file
		try{
			url = new URL("http://www.boi.org.il/currency.xml").openStream();
		}catch(Exception e){
			try
			{
				url = new FileInputStream("currency.xml");
			} catch (FileNotFoundException e1)
			{
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
		}
		
		DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
		
		//constructing the Table
		try
		{
			DocumentBuilder builder = factory.newDocumentBuilder();
			Document doc = builder.parse(url);
			
			//get Update Date
			NodeList updateDate = doc.getElementsByTagName("LAST_UPDATE");
			Node abc = updateDate.item(0);
			
			if(abc.getNodeType() == Node.ELEMENT_NODE){
				Element date = (Element) abc;
				upToDate = date.getTextContent();
			}
				
			//get rates details
			NodeList ratesList = doc.getElementsByTagName("CURRENCY");
			for(int i=0; i < ratesList.getLength(); ++i)
			{
				Node rate = ratesList.item(i);
				if(rate.getNodeType() == Node.ELEMENT_NODE)
				{
					Element rate_ = (Element)rate;
					NodeList infoList = rate_.getChildNodes();
					whereTo.writeUTF("~~~~~~Last Update~~~~~~\n" + upToDate + "\n");
					for(int j=0; j < infoList.getLength(); ++j)
					{
						Node temp = infoList.item(j);
						if(temp.getNodeType() == Node.ELEMENT_NODE)
						{
							Element info = (Element) temp;
							if(info.getTagName() == "NAME"){
								rates[i].setName(info.getTextContent());
								whereTo.writeChars("Name: " + rates[i].getName());
							}
								
							else if(info.getTagName() == "UNIT"){
								rates[i].setUnit(Integer.parseInt(info.getTextContent()));
								whereTo.writeChars(", Unit: " + rates[i].getUnit());
							}
							else if(info.getTagName() == "CURRENCYCODE"){
								rates[i].setcurrCode(info.getTextContent());
								whereTo.writeChars(", Curreny Code: " + rates[i].getcurrCode());
							}
							else if(info.getTagName() == "COUNTRY"){
								rates[i].setCountry(info.getTextContent());
								whereTo.writeChars(", Country: " + rates[i].getCountry());
							}
							else if(info.getTagName() == "RATE"){
								rates[i].setRate(Double.parseDouble(info.getTextContent()));
								whereTo.writeChars(", Rate: " + rates[i].getRate());
							}
							else if(info.getTagName() == "CHANGE"){
								rates[i].setChange(Double.parseDouble(info.getTextContent()));						
								whereTo.writeChars(", Change: " + rates[i].getChange() + "\n\n\n");
							}
						}
					}
				}
			}
		} catch (ParserConfigurationException e)
		{
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (SAXException e)
		{
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e)
		{
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		finally
		{
			try
			{
				if(fos != null)
					fos.close();
				if(whereTo != null)
					whereTo.close();
			} catch (IOException e)
			{
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		
		//set table values
		DefaultTableModel TModel = createTmodel();
		
	
		table = new JTable(TModel);
		rowSorter = new TableRowSorter<>(table.getModel());		//for text search
		table.setRowSorter(rowSorter);
		
		
		table.setBorder(BorderFactory.createLineBorder(Color.black));
	    
	    table.setEnabled(false);
		//center table text
		DefaultTableCellRenderer centerRenderer = new DefaultTableCellRenderer();
		centerRenderer.setHorizontalAlignment( JLabel.CENTER );
		 for(int x = 1; x < 3 ; x++)
	         table.getColumnModel().getColumn(x).setCellRenderer( centerRenderer );
		 
	}
	
	
	
	public DefaultTableModel createTmodel() {
		DefaultTableModel TModel = new DefaultTableModel();
		TModel.addColumn("Name");		
		TModel.addColumn("Rate");
		TModel.addColumn("Change");
		createRows(TModel);
		return TModel;
	}


	public void createRows (DefaultTableModel x){
		for(int i = 0; i < rates.length; ++i)
			x.addRow(new Object[]{rates[i].getUnit() + " " +  rates[i].getCountry() + " " + rates[i].getName(), rates[i].getRate(), rates[i].getChange()});
	}

	public Rate[] getRates() { return rates; }
	public String getUpdateDate() { return upToDate;}
	public JTable getTable() { return table; }
	public TableRowSorter getRowSorter() { return rowSorter; }
	public void addValue(String unitName, String Rate, String Change){ 
		((DefaultTableModel) table.getModel()).addRow(new Object[]{unitName, Rate, Change});
	}
	
	
	@Override
	public String toString() {
		
		String cosEmek = null;	
		for (int i = 0; i < rates.length; ++i){
			cosEmek += "Name: " + rates[i].getName() + ", Rate: " + rates[i].getRate() + ", Change:" + rates[i].getChange() + ", Country: " + rates[i].getCountry() + ", Currency Code: "  + rates[i].getcurrCode() + "\n";                                                                 ;
		}
		return cosEmek;
	}
}
