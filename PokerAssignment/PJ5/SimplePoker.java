package PJ5;
import java.util.*;

/*
Header in testPlaySimplePoker
*/

public class SimplePoker {

    // default constant values
    private static final int startingBalance=100;
    private static final int numberOfCards=5;

    // default constant payout value and currentHand types
    private static final int[] multipliers={1,2,3,5,6,9,25,50,250};
    private static final String[] goodHandTypes={ 
	  "Royal Pair" , "Two Pairs" , "Three of a Kind", "Straight", "Flush    ", 
	  "Full House", "Four of a Kind", "Straight Flush", "Royal Flush" };

    // must use only one deck
    private static final Decks oneDeck = new Decks(1);

    // holding current poker 5-card hand, balance, bet    
    private List<Card> currentHand;
    private int balance;
    private int bet;

    /** default constructor, set balance = startingBalance */
    public SimplePoker()
    {
	   this(startingBalance);
    }

    /** constructor, set given balance */
    public SimplePoker(int balance)
    {
	   this.balance= balance;
    }

    /** This display the payout table based on multipliers and goodHandTypes arrays */
    private void showPayoutTable()
    { 
    	System.out.println("\n\n");
    	System.out.println("Payout Table   	      Multiplier   ");
    	System.out.println("=======================================");
    	int size = multipliers.length;
    	for (int i=size-1; i >= 0; i--) 
        {
    		System.out.println(goodHandTypes[i]+"\t|\t"+multipliers[i]);
    	}
    	System.out.println("\n\n");
    }

    /** Check current currentHand using multipliers and goodHandTypes arrays
     *  Must print yourHandType (default is "Sorry, you lost") at the end of function.
     *  This can be checked by testCheckHands() and main() method.
     */
    private void checkHands()
    {
        int combination = checkCombination();
        switch(combination){
            case 1:
                System.out.println(goodHandTypes[0]);
                balance = balance + ( bet * multipliers[0] );
                break;
            case 2:
                System.out.println(goodHandTypes[1]);
                balance = balance + ( bet * multipliers[1] );
                break;
            case 3:
                System.out.println(goodHandTypes[2]);
                balance = balance + ( bet * multipliers[2] );
                break;
            case 4:
                System.out.println(goodHandTypes[3]);
                balance = balance + ( bet * multipliers[3] );
                break;
            case 5:
                System.out.println(goodHandTypes[4]);
                balance = balance + ( bet * multipliers[4] );
                break;
            case 6:
                System.out.println(goodHandTypes[5]);
                balance = balance + ( bet * multipliers[5] );
                break;
            case 7:
                System.out.println(goodHandTypes[6]);
                balance = balance + ( bet * multipliers[6] );
                break;
            case 8:
                System.out.println(goodHandTypes[7]);
                balance = balance + ( bet * multipliers[7] );
                break;
            case 9:
                System.out.println(goodHandTypes[8]);
                balance = balance + ( bet * multipliers[8] );
                break;
            default: 
                System.out.println("Sorry, you lost");
                break;
        }
    }


    /*************************************************
     *   add new private methods here ....
     *
     *************************************************/
    
    //check which combination is true
    private int checkCombination(){
        int combination = 0;
        
        if( checkRoyalPair() )
            combination = 1;
        if( checkTwoPair() )
            combination = 2;
        if( checkThreeOfAKind() )
            combination = 3;
        if( checkStraight() )
            combination = 4;
        if( checkFlush() )
            combination = 5;
        if( checkFullHouse() )
            combination = 6;
        if( checkFourOfAKind() )
            combination = 7;
        if( checkStraightFlush() )
            combination = 8;
        if( checkRoyalFlush() )
            combination = 9;
        
        return combination;
    }
    
    //check for royal pair
    private boolean checkRoyalPair(){
        Card[] array = sortRank();
        int countPair = 0;
        
        for( int i = 0; i < array.length - 1; i++ ){
            if( array[i].getRank() == array[i+1].getRank() ){
                if( array[i].getRank() > 10 && array[i].getRank() <= 13 ){
                    countPair++;
                }
            }
            if( countPair == 1 )
                return true;
        }
        return false;
    }
    
    //check for two pair
    private boolean checkTwoPair(){
        
        Card[] array = sortRank();
        int countPair = 0;
        
        for( int i = 0; i < array.length - 1; i++ ){
            if( array[i].getRank() == array[i+1].getRank() ){
                countPair++;
                i++;
            }
            if( countPair == 2 )
                return true;
        }
        return false;
    }
    
    //check for three of a kind
    private boolean checkThreeOfAKind(){
        
        Card[] array = sortRank();
        
        for( int i = 0; i < array.length - 2; i++ ){
            if( array[i].getRank() == array[i+1].getRank() && array[i].getRank() == array[i+2].getRank() ){
                return true;
            }   
        }
        return false;
    }
    
    //check for straight
    private boolean checkStraight(){
        Card[] array = sortRank();
        
        for( int i = 0; i < array.length - 1; i++ ){
            if( array[i + 1].getRank() != array[i].getRank() + 1 ){
                return false;
            }   
        }
        return true;
    }
    
    //check for flush
    private boolean checkFlush(){
        for(int i = 0; i < currentHand.size() - 1; i++){
            if(currentHand.get(i).getSuit() != currentHand.get(i+1).getSuit())
                return false;
        }
        return true;
    }
    
    //check for full house
    private boolean checkFullHouse(){
        Card[] array = sortRank();
        int rank1 = 1;
        int rank2 = 1;
        
        for( int i = 0; i < array.length - 1; i++ ){
            if( array[i].getRank() == array[0].getRank() )
                rank1++;
            if( array[i].getRank() == array[array.length - 1].getRank() )
                rank2++;
        }
        if( rank1 == 3 && rank2 == 2 )
            return true;
        if( rank1 == 2 && rank2 == 3 )
            return true;
        return false;
    }
    
    //check for four of a kind
    private boolean checkFourOfAKind(){
        Card[] array = sortRank();
        
        if( array[0].getRank() == array[array.length - 2 ].getRank() )
            return true;
        if( array[1].getRank() == array[array.length - 1 ].getRank() )
            return true;
        
        return false;
    }
    
    //check straight flush
    private boolean checkStraightFlush(){
        
        if( checkFlush() && checkStraight() )
            return true;
        return false;
    }
    
    //check royal flush
    private boolean checkRoyalFlush(){
        Card[] array = sortRank();
        int counter = 0;
        int rank = array[1].getRank();
        
        if( checkFlush() && array[0].getRank() == 1 && array[1].getRank() == 10 ){
            for( int i = 2; i < array.length; i++ ){
                if( array[i].getRank() == rank + 1)
                    counter++;
                    rank++;
            }
            if( counter == 3 )
                return true;
        }
        return false;
    }
    
    //sort deck by rank
    private Card[] sortRank(){
        Card[] array = toArray();
        
        for( int i = 0; i < array.length; i++ )
        {
            int min = i;
         
            for( int j = i + 1; j < array.length; j++ )
            {
                if( array[ j ].getRank() < array[ min ].getRank() )
                {
                    min = j;
                }
            }
     
            Card temp = array[ min ];
            array[ min ] = array[ i ];
            array[ i ] = temp;
        }
        return array;
    }
    
    //list to array
    private Card[] toArray(){
        return currentHand.toArray( new Card[0] );
    }
    
    public void play() 
    {
        //Show the payout table
        showPayoutTable();
        boolean running = true;
        
        while( running ){
    
            //Show balance and how much you want to bet
            System.out.println( "Balance: " + balance );
            Scanner scanner = new Scanner( System.in );
            System.out.println( "Bet: " );
            bet = scanner.nextInt();
            
            //Validate bet amount
            while( bet > balance ){
                System.out.println( "Enter valid bet: " );
                bet = scanner.nextInt();
            }
            
            //Update bet and deal cards
            balance = balance - bet;
            oneDeck.reset();
            oneDeck.shuffle();
            try{
                currentHand = oneDeck.deal(5);
            }
            catch( PlayingCardException e ){
                System.out.println("Error" + e);
                running = false;
            }
            
            //Hold chosen cards and deal new cards
            List<String> keepList = new ArrayList<>();
            List<Card> newHand = new ArrayList<>();
            
            System.out.println("Hand: " + currentHand.toString() + "\nWhat cards to you want to hold? (e.g. 1 3 4)" );
            scanner = new Scanner(System.in);
            keepList = Arrays.asList(scanner.nextLine().split(" "));
          
            int card_replace = numberOfCards - keepList.size();
            
            try{
                newHand = oneDeck.deal(card_replace);
            }
            catch( PlayingCardException e){
                System.out.println("Error " + e);
            }
          
            for(int i = 0; i < keepList.size(); i++){
                newHand.add(currentHand.get(Integer.parseInt(keepList.get(i))-1));
            }
            
            currentHand = newHand;
            System.out.println(currentHand.toString());
           
            //Check new hand
            checkHands();
            
            //Ask if the player want to play one more time or exit game because balance is zero
            Scanner answer = new Scanner( System.in );
            String answerGame;
            if( balance == 0 ){
                System.out.print("You balance is " + balance + "\nThank you for playing! Come back soon!");
                running = false;
            }
            else{
                System.out.println("Your balance: " + balance + "\nWant to play a new game? ( y or n )");
                answerGame = answer.nextLine();
                if( "n".equals(answerGame)){
                    System.out.print("Thank you for playing! Come back soon!");
                    running = false;
                }
                else{
                    System.out.println("Want to see playout table? ( y or n )");
                    answerGame = answer.nextLine();
                    if( "y".equals(answerGame)){
                        showPayoutTable();
                    }
                }
            }
        }
    }
    
    public void testCheckHands()
    {
      	try {
    		currentHand = new ArrayList<Card>();

    		// set Royal Flush
    		currentHand.add(new Card(1,3));
    		currentHand.add(new Card(10,3));
    		currentHand.add(new Card(12,3));
    		currentHand.add(new Card(11,3));
    		currentHand.add(new Card(13,3));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Straight Flush
    		currentHand.set(0,new Card(9,3));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Straight
    		currentHand.set(4, new Card(8,1));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Flush 
    		currentHand.set(4, new Card(5,3));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// "Royal Pair" , "Two Pairs" , "Three of a Kind", "Straight", "Flush	", 
    	 	// "Full House", "Four of a Kind", "Straight Flush", "Royal Flush" };

    		// set Four of a Kind
    		currentHand.clear();
    		currentHand.add(new Card(8,3));
    		currentHand.add(new Card(8,0));
    		currentHand.add(new Card(12,3));
    		currentHand.add(new Card(8,1));
    		currentHand.add(new Card(8,2));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Three of a Kind
    		currentHand.set(4, new Card(11,3));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Full House
    		currentHand.set(2, new Card(11,1));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Two Pairs
    		currentHand.set(1, new Card(9,1));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Royal Pair
    		currentHand.set(0, new Card(3,1));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// non Royal Pair
    		currentHand.set(2, new Card(3,3));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");
      	}
      	catch (Exception e)
      	{
		  System.out.println(e.getMessage());
      	}
    }

    /* Quick testCheckHands() */
    public static void main(String args[]) 
    {
	   SimplePoker mypokergame = new SimplePoker();
	   mypokergame.testCheckHands();
    }
}
