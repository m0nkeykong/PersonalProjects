package RH.PE;

import javax.imageio.ImageIO;
import javax.swing.*;
import javax.swing.event.DocumentEvent;
import javax.swing.event.DocumentListener;
import javax.swing.table.DefaultTableModel;

import java.awt.*;
import java.awt.event.*;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.net.URL;

public class View extends JFrame {
	private JTextField insertion, conversion;
	private JButton reset, convert, swap, update, table, addVal;
	private JPanel panel, insertPanel, convertPanel, searchPanel;
	private JFrame tableFrame;
	private GridBagConstraints location;
	private JComboBox<String> comboBoxInsert;
	private JComboBox<String> comboBoxConvert;
	private double divider;
	private double multipication;
	private Model exec;

	public JLabel insertPic;
	public JLabel convertPic;
	public ImageIcon[] myPictures;
	
	private JTextField jtfFilter;	
	
	public String insertUnitName, insertRate, insertChange;
	
	public View() throws IOException {
		super("Curreny Exchange Rates");
		setLayout(new FlowLayout());

		//creation of the engine
		exec = new Model();
		
		this.setTitle("Curreny Exchange Rates | Last Update: " + exec.getUpdateDate());
		panel = new JPanel(new GridBagLayout());
		location = new GridBagConstraints();
		location.insets = new Insets(10, 10, 10, 10);

		// Text Field Creation
		insertion = new JTextField("1", 10);
		location.gridx = 0;
		location.gridy = 1;
		panel.add(insertion, location);

		String tempRate = (String.valueOf((1 / (exec.getRates()[0].getRate()))));
		conversion = new JTextField(tempRate, 10);
		conversion.setEditable(false);
		location.gridx = 2;
		location.gridy = 1;
		panel.add(conversion, location);

		// Button Creation
		table = new JButton("Table");
		location.gridx = 0;
		location.gridy = 2;
		panel.add(table, location);
		
		update = new JButton("Update");
		location.gridx = 1;
		location.gridy = 2;
		panel.add(update, location);
		
		reset = new JButton("Reset");
		location.gridx = 2;
		location.gridy = 2;
		panel.add(reset, location);

		convert = new JButton("Convert");
		location.gridx = 1;
		location.gridy = 1;
		panel.add(convert, location);

		swap = new JButton("Swap");
		location.gridx = 1;
		location.gridy = 0;
		panel.add(swap, location);

		//selection box creation
		insertPanel = new JPanel(new BorderLayout());
		convertPanel = new JPanel(new BorderLayout());
		
		//table search
		jtfFilter = new JTextField(10);
		jtfFilter.getDocument().addDocumentListener(new DocumentListener(){

            public void insertUpdate(DocumentEvent e) {
                String text = jtfFilter.getText();

                if (text.trim().length() == 0) {
                    exec.getRowSorter().setRowFilter(null);
                } else {
                	exec.getRowSorter().setRowFilter(RowFilter.regexFilter("(?i)" + text));
                }
            }
            public void removeUpdate(DocumentEvent e) {
                String text = jtfFilter.getText();

                if (text.trim().length() == 0) {
                	exec.getRowSorter().setRowFilter(null);
                } else {
                	exec.getRowSorter().setRowFilter(RowFilter.regexFilter("(?i)" + text));
                }
            }
            public void changedUpdate(DocumentEvent e) {
                throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
            }

        });
		
		
		
		// Flags creation
		myPictures = new ImageIcon[15];
		
		for(int i = 0; i < 15; ++i)
			myPictures[i] = new ImageIcon("./flags/"+ i + ".gif");
		
		
		insertPic = new JLabel(myPictures[0]);
		convertPic = new JLabel(myPictures[1]);
		insertPic.setVisible(true);
		convertPic.setVisible(true);
		
		
		// Combo Box Creation
		comboBoxInsert = new JComboBox<String>(new String[] { "NIS", "USD", "GBP", "JPY", "EUR", "AUD", "CAD", "DKK",
				"NOK", "ZAR", "SEK", "CHF", "JOD", "LBP", "EGP" });
		location.gridx = 0;
		location.gridy = 0;
		insertPanel.add(comboBoxInsert, BorderLayout.EAST);
		multipication = 1;
		insertPanel.add(insertPic, BorderLayout.WEST);
		panel.add(insertPanel, location);
		
		
		comboBoxConvert = new JComboBox<String>(new String[] { "NIS", "USD", "GBP", "JPY", "EUR", "AUD", "CAD", "DKK",
				"NOK", "ZAR", "SEK", "CHF", "JOD", "LBP", "EGP" });
		location.gridx = 2;
		location.gridy = 0;
		convertPanel.add(comboBoxConvert, BorderLayout.EAST);
		comboBoxConvert.setSelectedIndex(1);
		divider = exec.getRates()[0].getRate();
		convertPanel.add(convertPic, BorderLayout.WEST);
		panel.add(convertPanel, location);
		
		// Adding action listeners
		theHandler handler = new theHandler();
		insertion.addActionListener(handler);
		reset.addActionListener(handler);
		swap.addActionListener(handler);
		convert.addActionListener(handler);
		table.addActionListener(handler);
		update.addActionListener(handler);
		
		// Adding action listeners to selections
		theChanger changer = new theChanger();
		comboBoxInsert.addActionListener(changer);
		comboBoxConvert.addActionListener(changer);

		
		
		//adding the table
		tableFrame = new JFrame();
		tableFrame.setLayout(new FlowLayout());
		
		addVal = new JButton("Add Value");
		addVal.addActionListener(handler);
		tableFrame.add(addVal, BorderLayout.EAST);
		
		
		tableFrame.add(new JScrollPane(exec.getTable()));
		tableFrame.setDefaultCloseOperation(JFrame.HIDE_ON_CLOSE);
		tableFrame.setSize(500, 700);
		
		
		//search box for table
		searchPanel = new JPanel(new BorderLayout());
		searchPanel.add(new JLabel("Specify a word to match:"), BorderLayout.WEST);
		searchPanel.add(jtfFilter, BorderLayout.CENTER);
		tableFrame.add(searchPanel);

        
        Dimension dim = Toolkit.getDefaultToolkit().getScreenSize();
		tableFrame.setLocation(dim.width/2-this.getSize().width/2 - 480, dim.height/2-this.getSize().height/2);
		this.setLocation(dim.width/2-this.getSize().width/2, dim.height/2-this.getSize().height/2);
		add(panel);
		
		setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		setSize(500,250);
		setVisible(true);
	}


	private class theChanger implements ActionListener {
		@Override
		public void actionPerformed(ActionEvent eve) {

			if (eve.getSource() == comboBoxConvert) {
				if (comboBoxConvert.getSelectedIndex() == 0){
					divider = 1;
					convertPic.removeAll();
					convertPic.setIcon(myPictures[0]);
				}
				else if (comboBoxConvert.getSelectedIndex() != 0) {
					divider = exec.getRates()[(comboBoxConvert.getSelectedIndex() - 1)].getRate();
					convertPic.removeAll();
					convertPic.setIcon(myPictures[comboBoxConvert.getSelectedIndex()]);
				}
			}

			else if (eve.getSource() == comboBoxInsert) {
				if (comboBoxInsert.getSelectedIndex() == 0){
					multipication = 1;
					insertPic.removeAll();
					insertPic.setIcon(myPictures[0]);
				}
				else if (comboBoxInsert.getSelectedIndex() != 0) {
					multipication = exec.getRates()[(comboBoxInsert.getSelectedIndex() - 1)].getRate();
					insertPic.removeAll();
					insertPic.setIcon(myPictures[comboBoxInsert.getSelectedIndex()]);
				}
			}

		}
	}

	private class theHandler implements ActionListener {
		public void actionPerformed(ActionEvent event) {
			String tempCalc = "";
			double tempINS = 0; // in order to manipulate the value

			if (event.getSource() == insertion) {
				tempCalc = event.getActionCommand(); // we need to change text
														// to double
				tempINS = Double.parseDouble(tempCalc); // and then convert back
														// from double
														// to text
				tempCalc = String.valueOf(tempINS);
				conversion.setText(tempCalc);
			
			} else if (event.getSource() == table) {
				tableFrame.setVisible(true);
				
			} else if (event.getSource() == update){
				updateDataBase();
				
			} else if (event.getSource() == addVal){
				DefaultTableModel temp = (DefaultTableModel)exec.getTable().getModel();
				String insertUnitName = JOptionPane.showInputDialog("Enter Unit and Name");
				String insertRate = JOptionPane.showInputDialog("Enter The Rate");
				String insertChange = JOptionPane.showInputDialog("Enter Change");
				exec.addValue(insertUnitName, insertRate, insertChange);
				temp.fireTableDataChanged();
				
			}else if (event.getSource() == reset) {
				insertion.setText("1");
				comboBoxInsert.setSelectedIndex(0);
				comboBoxConvert.setSelectedIndex(1);
				divider = exec.getRates()[0].getRate();
				multipication = 1;
			} else if (event.getSource() == swap) {
				// swap table values
				int x = comboBoxInsert.getSelectedIndex();
				comboBoxInsert.setSelectedIndex(comboBoxConvert.getSelectedIndex());
				comboBoxConvert.setSelectedIndex(x);

				// swap conversion values and flags
				if (comboBoxConvert.getSelectedIndex() == 0){
					divider = 1;
					convertPic.removeAll();
					convertPic.setIcon(myPictures[0]);
				}
				else if (comboBoxConvert.getSelectedIndex() != 0) {
					divider = exec.getRates()[(comboBoxConvert.getSelectedIndex() - 1)].getRate();
					convertPic.removeAll();
					convertPic.setIcon(myPictures[comboBoxConvert.getSelectedIndex()]);
				}

				if (comboBoxInsert.getSelectedIndex() == 0){
					multipication = 1;
					insertPic.removeAll();
					insertPic.setIcon(myPictures[0]);
				}	
				else if (comboBoxInsert.getSelectedIndex() != 0) {
					multipication = exec.getRates()[(comboBoxInsert.getSelectedIndex() - 1)].getRate();
					insertPic.removeAll();
					insertPic.setIcon(myPictures[comboBoxInsert.getSelectedIndex()]);
				}

				// here we need to change the flag icons (right -> left)

			} else if (event.getSource() == convert) {
				tempCalc = insertion.getText(); // we need to change text to
												// double

				tempINS = Double.parseDouble(tempCalc); // and then convert back
														// from double
														// to text

				tempINS = ((tempINS * multipication) / divider);

				tempCalc = String.valueOf(tempINS);
				conversion.setText(tempCalc);
			}
		}
	}
	
	public void updateDataBase(){
		//xml parse XML
		DefaultTableModel dm = (DefaultTableModel)exec.getTable().getModel();
		dm.setRowCount(0);
		exec.createRows(dm);
		dm.fireTableDataChanged();
	}
}
